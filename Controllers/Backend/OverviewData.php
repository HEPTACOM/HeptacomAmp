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
        if (is_null($shop = $this->getShopRepository()->find($this->Request()->getParam('shop')))) {
            $this->View()->assign(['success' => false, 'data' => []]);
            return;
        }

        /** @var Category $category */
        if (is_null($category = $this->getCategoryRepository()->find($this->Request()->getParam('category')))) {
            $this->View()->assign(['success' => false, 'data' => []]);
            return;
        }

        if (empty($articles = array_map([$this->urlFactory, 'dehydrate'], $this->urlSearcher->findArticlesOfCategory($shop, $category)))) {
            $this->View()->assign(['success' => false, 'data' => []]);
        } else {
            $this->View()->assign(['success' => true, 'data' => $articles]);
        }
    }

    /// TODO undo 4037b1c9780ed0faaa18192ee4157bf203981bd4 for customs and categories in cache warming
}
