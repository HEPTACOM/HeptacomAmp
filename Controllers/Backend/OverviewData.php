<?php

use HeptacomAmp\Factory\UrlFactory;
use HeptacomAmp\Services\Searcher\UrlSearcher;
use HeptacomAmp\Services\WebRequest;
use Shopware\Components\CSRFWhitelistAware;
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
     * @var WebRequest
     */
    private $webRequest;

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
            'pingUrl',
            'getUrl',
        ];
    }

    public function preDispatch()
    {
        parent::preDispatch();
        $this->urlFactory = $this->container->get('heptacom_amp.factory.url');
        $this->urlSearcher = $this->container->get('heptacom_amp.services.searcher.url');
        $this->webRequest = $this->container->get('heptacom_amp.services.web_request');
        $this->View()->assign(['success' => false, 'data' => []]);
    }

    /**
     * @return ShopRepository
     */
    private function getShopRepository()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getModelManager()->getRepository(Shop::class);
    }

    /**
     * @return CategoryRepository
     */
    private function getCategoryRepository()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getModelManager()->getRepository(Category::class);
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getShops
     */
    public function getShopsAction()
    {
        if (!empty($shops = array_map([$this->urlFactory, 'dehydrate'], $this->urlSearcher->findShops()))) {
            $this->returnSuccess($shops);
        }
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getCategories
     */
    public function getCategoriesAction()
    {
        /** @var Shop $shop */
        if (!is_null($shop = $this->getShopRepository()->find($this->Request()->getParam('shop'))) &&
            !empty($categories = array_map([$this->urlFactory, 'dehydrate'], $this->urlSearcher->findCategoriesOfShop($shop)))) {
            $this->returnSuccess($categories);
        }
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getArticles
     */
    public function getArticlesAction()
    {
        /** @var Shop $shop */
        /** @var Category $category */
        if (!is_null($shop = $this->getShopRepository()->find($this->Request()->getParam('shop'))) &&
            !is_null($category = $this->getCategoryRepository()->find($this->Request()->getParam('category'))) &&
            !empty($articles = array_map([$this->urlFactory, 'dehydrate'], $this->urlSearcher->findArticlesOfCategory($shop, $category)))) {
            $this->returnSuccess($articles);
        }
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/pingUrl
     */
    public function pingUrlAction()
    {
        $url = $this->Request()->getParam('url');
        $code = $this->webRequest->ping($url);
        $this->returnSuccess([
            'code' => $code,
            'url' => $url,
        ]);
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getUrl
     */
    public function getUrlAction()
    {
        $url = $this->Request()->getParam('url');
        $html = $this->webRequest->get($url);
        $this->returnSuccess([
            'html' => $html,
        ]);
    }

    /**
     * @param array $data
     */
    protected function returnSuccess(array $data)
    {
        $this->View()->assign([
            'success' => true,
            'data' => $data,
        ]);
    }

    /// TODO undo 4037b1c9780ed0faaa18192ee4157bf203981bd4 for customs and categories in cache warming
}
