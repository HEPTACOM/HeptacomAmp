<?php

namespace HeptacomAmp\Services\Searcher;

use HeptacomAmp\Factory\ConfigurationFactory;
use HeptacomAmp\Factory\UrlFactory;
use HeptacomAmp\Reader\ConfigurationReader;
use HeptacomAmp\Struct\UrlStruct;
use Shopware\Bundle\SearchBundle\ProductSearchInterface;
use Shopware\Bundle\SearchBundle\StoreFrontCriteriaFactoryInterface;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ListProduct;
use Shopware\Models\Category\Category;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Category\Repository as CategoryRepository;
use Shopware\Models\Shop\Shop;

/**
 * Class UrlSearcher
 * @package HeptacomAmp\Services\Searcher
 */
class UrlSearcher
{
    /**
     * @var ConfigurationFactory
     */
    private $configurationFactory;

    /**
     * @var ConfigurationReader
     */
    private $configurationReader;

    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var UrlFactory
     */
    private $urlFactory;

    /**
     * @var ContextServiceInterface
     */
    private $shopContextService;

    /**
     * @var StoreFrontCriteriaFactoryInterface
     */
    private $storeFrontCriteriaFactory;

    /**
     * @var ProductSearchInterface
     */
    private $productSearchService;

    /**
     * UrlSearcher constructor.
     * @param ConfigurationFactory $configurationFactory
     * @param ConfigurationReader $configurationReader
     * @param ShopRepository $shopRepository
     * @param CategoryRepository $categoryRepository
     * @param UrlFactory $urlFactory
     * @param ContextServiceInterface $shopContextService
     * @param StoreFrontCriteriaFactoryInterface $storeFrontCriteriaFactory
     * @param ProductSearchInterface $productSearchService
     */
    public function __construct(
        ConfigurationFactory $configurationFactory,
        ConfigurationReader $configurationReader,
        ShopRepository $shopRepository,
        CategoryRepository $categoryRepository,
        UrlFactory $urlFactory,
        ContextServiceInterface $shopContextService,
        StoreFrontCriteriaFactoryInterface $storeFrontCriteriaFactory,
        ProductSearchInterface $productSearchService
    ) {
        $this->configurationFactory = $configurationFactory;
        $this->configurationReader = $configurationReader;
        $this->shopRepository = $shopRepository;
        $this->urlFactory = $urlFactory;
        $this->categoryRepository = $categoryRepository;
        $this->shopContextService = $shopContextService;
        $this->storeFrontCriteriaFactory = $storeFrontCriteriaFactory;
        $this->productSearchService = $productSearchService;
    }

    /**
     * @return UrlStruct[]
     */
    public function findShops()
    {
        /** @var Shop[] $shops */
        $shops = $this->shopRepository->getActiveShops();
        $shops = array_filter($shops, [$this, 'hasShopAmpEnabled']);
        return array_map([$this->urlFactory, 'hydrateFromShop'], $shops);
    }

    /**
     * @return UrlStruct[]
     */
    public function findCategoriesOfShop(Shop $shop)
    {
        $qb = $this->categoryRepository->createQueryBuilder('categories');

        $qb->select(['categories.id AS categoriesId'])
            ->distinct()
            ->andWhere($qb->expr()->like('categories.path', ':search'))
            ->setParameter('search', "%|{$shop->getCategory()->getId()}|%")
            ->innerJoin('categories.articles', 'articles')
            ->andWhere($qb->expr()->eq('articles.active', 1))
            ->innerJoin('articles.details', 'details')
            ->andWhere($qb->expr()->isNotNull('details.number'))
            ->andWhere($qb->expr()->neq($qb->expr()->length($qb->expr()->trim('details.number')), 0));

        $categoryIds = array_column($qb->getQuery()->getArrayResult(), 'categoriesId');
        $categories = array_map([$this->categoryRepository, 'find'], $categoryIds);
        return array_map(function (Category $category) use ($shop) {
            return $this->urlFactory->hydrateFromCategory($shop, $category);
        }, $categories);
    }

    /**
     * @return UrlStruct[]
     */
    public function findArticlesOfCategory(Shop $shop, Category $category)
    {
        $context = $this->shopContextService->createShopContext($shop->getId());
        $criteria = $this->storeFrontCriteriaFactory->createBaseCriteria([$category->getId()], $context);
        return array_map(function (ListProduct $product) use ($shop) {
            return $this->urlFactory->hydrateFromProduct($shop, $product);
        }, array_values($this->productSearchService->search($criteria, $context)->getProducts()));
    }

    /**
     * @param Shop $shop
     * @return bool
     */
    protected function hasShopAmpEnabled(Shop $shop)
    {
        return $this->configurationFactory->hydrate($this->configurationReader->read($shop->getId()))->isActive();
    }
}
