<?php

namespace HeptacomAmp\Services\Searcher;

use HeptacomAmp\Factory\ConfigurationFactory;
use HeptacomAmp\Factory\UrlFactory;
use HeptacomAmp\Reader\ConfigurationReader;
use HeptacomAmp\Struct\UrlStruct;
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
     * UrlSearcher constructor.
     * @param ConfigurationFactory $configurationFactory
     * @param ConfigurationReader $configurationReader
     * @param ShopRepository $shopRepository
     * @param CategoryRepository $categoryRepository
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        ConfigurationFactory $configurationFactory,
        ConfigurationReader $configurationReader,
        ShopRepository $shopRepository,
        CategoryRepository $categoryRepository,
        UrlFactory $urlFactory
    ) {
        $this->configurationFactory = $configurationFactory;
        $this->configurationReader = $configurationReader;
        $this->shopRepository = $shopRepository;
        $this->urlFactory = $urlFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return UrlStruct[]
     */
    public function findShops()
    {
        // TODO get only active ones
        /** @var Shop[] $shops */
        $shops = $this->shopRepository->findAll();
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
     * @param Shop $shop
     * @return bool
     */
    protected function hasShopAmpEnabled(Shop $shop)
    {
        return $this->configurationFactory->hydrate($this->configurationReader->read($shop->getId()))->isActive();
    }
}
