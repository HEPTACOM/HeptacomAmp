<?php

namespace HeptacomAmp\Components;

use Shopware\Bundle\SearchBundle\ProductSearch;
use Shopware\Bundle\SearchBundle\StoreFrontCriteriaFactory;
use Shopware\Bundle\StoreFrontBundle\Service\Core\CategoryService;
use Shopware\Bundle\StoreFrontBundle\Service\Core\ContextService;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Category\Category;
use Shopware\Models\Category\Repository as CategoryRepository;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Shop\Shop;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CacheWarmer
 * @package HeptacomAmp\Components
 */
class CacheWarmer
{
    /**
     * @var DispatchSimulator
     */
    private $dispatchSimulator;

    /**
     * @var ContextService
     */
    private $contextService;

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var StoreFrontCriteriaFactory
     */
    private $criteriaFactory;

    /**
     * @var ProductSearch
     */
    private $productSearch;

    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * CacheWarmer constructor.
     * @param DispatchSimulator $dispatchSimulator
     * @param ContextService $contextService
     * @param CategoryService $categoryService
     * @param StoreFrontCriteriaFactory $criteriaFactory
     * @param ProductSearch $productSearch
     * @param ModelManager $modelManager
     */
    public function __construct(
        DispatchSimulator $dispatchSimulator,
        ContextService $contextService,
        CategoryService $categoryService,
        StoreFrontCriteriaFactory $criteriaFactory,
        ProductSearch $productSearch,
        ModelManager $modelManager
    )
    {
        $this->dispatchSimulator = $dispatchSimulator;
        $this->contextService = $contextService;
        $this->categoryService = $categoryService;
        $this->criteriaFactory = $criteriaFactory;
        $this->productSearch = $productSearch;
        $this->modelManager = $modelManager;

        $this->shopRepository = $this->modelManager->getRepository(Shop::class);
        $this->categoryRepository = $this->modelManager->getRepository(Category::class);
    }

    public function injectOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function warmUp()
    {
        /** @var Shop[] $shops */
        $shops = $this->shopRepository->findBy(['active' => true]);

        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findBy(['active' => true]);

        $categoryIds = $this->extractCategoryIds($categories);

        foreach ($shops as $shop) {
            $articleIds = $this->getArticleIds($shop, $categoryIds);

            if (isset($this->output)) {
                $progress = new ProgressBar($this->output, count($articleIds));
                $progress->start();
            }

            foreach ($articleIds as $articleId) {
                $this->dispatchSimulator->request($shop, [
                    'controller' => 'heptacomAmpDetail',
                    'sArticle' => $articleId
                ]);

                if (isset($this->output) && isset($progress)) {
                    $progress->advance();
                }
            }

            if (isset($this->output) && isset($progress)) {
                $progress->finish();
                $this->output->writeln('');
            }
        }
    }

    /**
     * @param Category[] $categories
     * @return int[]
     */
    private function extractCategoryIds(array $categories)
    {
        $ids = [];
        foreach ($categories as $category) {
            $ids[] = $category->getId();
        }
        return $ids;
    }

    /**
     * @param Shop $shop
     * @param int[] $categoryIds
     * @return int[]
     */
    private function getArticleIds(Shop $shop, array $categoryIds)
    {
        $context = $this->contextService->createShopContext($shop->getId());
        $criteria = $this->criteriaFactory->createBaseCriteria($categoryIds, $context);

        $searchResult = $this->productSearch->search($criteria, $context);

        $articleIds = [];
        foreach ($searchResult->getProducts() as $product) {
            $articleIds[] = $product->getId();
        }

        return $articleIds;
    }
}
