<?php

use HeptacomAmp\Factory\UrlFactory;
use HeptacomAmp\Services\Searcher\UrlSearcher;
use Shopware\Bundle\SearchBundle\ProductSearchInterface;
use Shopware\Bundle\SearchBundle\StoreFrontCriteriaFactoryInterface;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ListProduct;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Components\Logger;
use Shopware\Models\Category\Category;
use Shopware\Models\Category\Repository as CategoryRepository;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Shop\Shop;

/**
 * Class Shopware_Controllers_Backend_HeptacomAmpOverviewData
 */
class Shopware_Controllers_Backend_HeptacomAmpOverviewData extends Shopware_Controllers_Api_Rest implements CSRFWhitelistAware
{
    /**
     * @var UrlFactory
     */
    private $urlFactory;

    /**
     * @var UrlSearcher
     */
    private $urlSearcher;

    /**
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return [
            'getShops',
            'getCategories',
            'getArticles',
            'getCategories',
            'getCustoms',
        ];
    }

    public function preDispatch()
    {
        parent::preDispatch();
        $this->urlFactory = $this->container->get('heptacom_amp.factory.url');
        $this->urlSearcher = $this->container->get('heptacom_amp.services.searcher.url');
    }

    /**
     * @return ShopRepository
     */
    private function getShopRepository()
    {
        return $this->container->get('models')->getRepository(Shop::class);
    }

    /**
     * @return CategoryRepository
     */
    private function getCategoryRepository()
    {
        return $this->container->get('models')->getRepository(Category::class);
    }

    /**
     * @param Category $category
     * @return array|bool|mixed
     */
    private function getDiscoverableArticles(Shop $shop, Category $category)
    {
        try {
            /** @var ContextServiceInterface $shopService */
            $shopService = $this->container->get('shopware_storefront.context_service');
            $context = $shopService->createShopContext($shop->getId());
            /** @var StoreFrontCriteriaFactoryInterface $criteriaFactory */
            $criteriaFactory = $this->container->get('shopware_search.store_front_criteria_factory');
            $criteria = $criteriaFactory->createBaseCriteria([$category->getId()], $context);
            /** @var ProductSearchInterface $productSearch */
            $productSearch = $this->container->get('shopware_search.product_search');

            return array_map(function (ListProduct $listProduct) {
                return [
                    'id' => $listProduct->getId(),
                    'name' => $listProduct->getName(),
                ];
            }, $productSearch->search($criteria, $context)->getProducts());
        } catch (Exception $exception) {
            /** @var Logger $logger */
            $logger = $this->get('pluginlogger');
            $logger->error($exception->getMessage());

            return [];
        }
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getShops
     */
    public function getShopsAction()
    {
        if (empty($shops = array_map([$this->urlFactory, 'dehydrate'], $this->urlSearcher->findShops()))) {
            $this->View()->assign(['success' => false, 'data' => []]);
        } else {
            $this->View()->assign(['success' => true, 'data' => $shops]);
        }
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getCategories
     */
    public function getCategoriesAction()
    {
        /** @var Shop $shop */
        if (is_null($shop = $this->getShopRepository()->find($this->Request()->getParam('shop')))) {
            $this->View()->assign(['success' => false, 'data' => []]);
            return;
        }

        if (empty($categories = array_map([$this->urlFactory, 'dehydrate'], $this->urlSearcher->findCategoriesOfShop($shop)))) {
            $this->View()->assign(['success' => false, 'data' => []]);
        } else {
            $this->View()->assign(['success' => true, 'data' => $categories]);
        }
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getArticles
     */
    public function getArticlesAction()
    {
        /** @var Shop $shop */
        $shop = $this->getShopRepository()->find($this->Request()->getParam('shop'));
        /** @var Category $category */
        $category = $this->getCategoryRepository()->find($this->Request()->getParam('category'));

        $result = [];
        $articles = $this->getDiscoverableArticles($shop, $category);

        foreach ($articles as &$article) {
            $result[] = [
                'name' => $article['name'],
                'test_url' => $this->urlFactory->getUrl($shop, 'frontend', 'detail', 'index', ['sArticle' => $article['id'], 'amp' => 1]),
                'urls' => [
                    'mobile' => $this->urlFactory->getUrl($shop, 'frontend', 'detail', 'index', ['sArticle' => $article['id'], 'amp' => 1]),
                    'desktop' => $this->urlFactory->getUrl($shop, 'frontend', 'detail', 'index', ['sArticle' => $article['id']])
                ],
            ];
        }

        if (empty($result)) {
            $this->View()->assign(['success' => false, 'data' => []]);
        } else {
            $this->View()->assign(['success' => true, 'data' => $result]);
        }
    }

    /// TODO undo 4037b1c9780ed0faaa18192ee4157bf203981bd4 for customs and categories in cache warming
}
