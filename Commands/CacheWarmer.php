<?php

namespace HeptacomAmp\Commands;

use HeptacomAmp\Components\DispatchSimulator;
use Shopware\Bundle\SearchBundle\ProductSearch;
use Shopware\Bundle\SearchBundle\StoreFrontCriteriaFactory;
use Shopware\Bundle\StoreFrontBundle\Service\Core\CategoryService;
use Shopware\Bundle\StoreFrontBundle\Service\Core\ContextService;
use Shopware\Commands\ShopwareCommand;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Category\Category;
use Shopware\Models\Category\Repository as CategoryRepository;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Shop\Shop;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CacheWarmer
 * @package HeptacomAmp\Commands
 */
class CacheWarmer extends ShopwareCommand
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

    protected function configure()
    {
        $this->setName('heptacom:amp:cache:generate')
            ->setDescription('Generate cache for AMP pages.')
            ->setHelp('The <info>%command.name%</info> generates a cached copy of the AMP pages.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->prepareServices();

        /** @var Shop[] $shops */
        $shops = $this->shopRepository->findBy(['active' => true]);

        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findAll();

        $categoryIds = $this->extractCategoryIds($categories);

        foreach ($shops as $shop) {
            $articleIds = $this->getArticleIds($shop, $categoryIds);

            $progress = new ProgressBar($output, count($articleIds));
            $progress->start();

            foreach ($articleIds as $articleId) {
                $this->dispatchSimulator->request($shop, [
                    'controller' => 'heptacomAmpDetail',
                    'sArticle' => $articleId
                ]);

                $progress->advance();
            }

            $progress->finish();
            $output->writeln('');
        }
    }

    private function prepareServices()
    {
        $this->dispatchSimulator = $this->container->get('heptacom_amp.components.dispatch_simulator');
        $this->contextService = $this->container->get('shopware_storefront.context_service');
        $this->categoryService = $this->container->get('shopware_storefront.category_service');
        $this->criteriaFactory = $this->container->get('shopware_search.store_front_criteria_factory');
        $this->productSearch = $this->container->get('shopware_search.product_search');
        $this->modelManager = $this->container->get('Models');

        $this->shopRepository = $this->modelManager->getRepository(Shop::class);
        $this->categoryRepository = $this->modelManager->getRepository(Category::class);
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

        $searchResult = $this->productSearch->search(
            $criteria,
            $context
        );

        $articleIds = [];
        foreach ($searchResult->getProducts() as $product) {
            $articleIds[] = $product->getId();
        }

        return $articleIds;
    }
}
