<?php

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Components\Routing\Context;
use Shopware\Components\Routing\Router;
use Shopware\Models\Article\Article;
use Shopware\Models\Category\Category;
use Shopware\Models\Shop\Shop;
use Shopware\Models\Site\Site;

/**
 * Class Shopware_Controllers_Backend_HeptacomAmpOverviewData
 */
class Shopware_Controllers_Backend_HeptacomAmpOverviewData extends Shopware_Controllers_Api_Rest implements CSRFWhitelistAware
{
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

    /**
     * @return EntityRepository
     */
    private function getArticleRepository()
    {
        return $this->container->get('models')->getRepository(Article::class);
    }

    /**
     * @return EntityRepository
     */
    private function getShopRepository()
    {
        return $this->container->get('models')->getRepository(Shop::class);
    }

    /**
     * @return EntityRepository
     */
    private function getCustomRepository()
    {
        return $this->container->get('models')->getRepository(Site::class);
    }

    /**
     * @return EntityRepository
     */
    private function getCategoryRepository()
    {
        return $this->container->get('models')->getRepository(Category::class);
    }

    /**
     * @param Shop $shop
     * @return Router
     */
    private function createRouter(Shop $shop)
    {
        $router = $this->container->get('router');
        /** @var $config \Shopware_Components_Config */
        $config = $this->container->get('config');
        // Register the shop (we're to soon)
        $config->setShop($shop);

        $context = $router->getContext();
        $newContext = Context::createFromShop($shop, $config);
        // Reuse the host
        if ($newContext->getHost() === null) {
            $newContext->setHost($context->getHost());
            $newContext->setBaseUrl($context->getBaseUrl());
            // Reuse https
            if (!$newContext->isSecure()) {
                $newContext->setSecure($context->isSecure());
                $newContext->setSecureBaseUrl($context->getSecureBaseUrl());
            }
        }
        $router->setContext($newContext);
        return $router;
    }

    /**
     * @param Router $router
     * @param string $controller
     * @param string[] $params
     * @param string $action
     * @return string
     */
    private function getUrl(Router $router, $controller, array $params, $action = 'index')
    {
        return str_replace(
            'http://',
            'https://',
            $router->assemble(array_merge([
                    'module' => 'frontend',
                    'controller' => $controller,
                    'action' => $action
                ], $params)));
    }

    /**
     * @param Article $article
     * @return bool
     */
    private static function discoverableArticles(Article $article)
    {
        if ($article->getCategories()->count() == 0) {
            return false;
        }

        if (!$article->getActive()) {
            return false;
        }

        $now = new DateTime();
        if (!is_null($article->getAvailableFrom()) && $now < $article->getAvailableFrom()) {
            return false;
        }

        if (!is_null($article->getAvailableTo()) && $now > $article->getAvailableTo()) {
            return false;
        }

        return !empty($article->getMainDetail()->getNumber());
    }

    /**
     * @param Shop $shop
     * @return bool
     */
    private static function discoverableShop(Shop $shop)
    {
        $newCategories = [$shop->getCategory()];

        while (!empty($newCategories)) {
            $newerCategories = [];

            foreach ($newCategories as $category) {
                /** @var Category $category */

                if ($category->getActive()) {
                    if (!$category->getArticles()->isEmpty()) {
                        foreach ($category->getArticles() as $article) {
                            if (static::discoverableArticles($article)) {
                                return true;
                            }
                        }
                    }

                    foreach ($category->getChildren() as $subCategory) {
                        $newerCategories[] = $subCategory;
                    }
                }
            }

            $newCategories = $newerCategories;
        }

        return false;
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getShops
     */
    public function getShopsAction()
    {
        $shops = $this->getShopRepository()
                      ->createQueryBuilder('shops')
                      ->andWhere('shops.active = 1')
                      ->getQuery()
                      ->getResult(Query::HYDRATE_OBJECT);

        $rawShops = [];
        $shops = array_filter($shops, [Shopware_Controllers_Backend_HeptacomAmpOverviewData::class, 'discoverableShop']);

        foreach ($shops as $shop) {
            /** @var Shop $shop */

            $rawShops[] = [
                'id' => $shop->getId(),
                'name' => $shop->getName(),
            ];
        }

        $this->View()->assign(['success' => true, 'data' => $rawShops]);
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getCategories
     */
    public function getCategoriesAction()
    {
        $shop = $this->getShopRepository()->find($this->Request()->getParam('shop'));

        $rawCategories = [];
        $newCategories = [$shop->getCategory()];

        while (!empty($newCategories)) {
            $newerCategories = [];

            foreach ($newCategories as $category) {
                /** @var Category $category */

                if ($category->getActive()) {
                    if (!$category->getArticles()->isEmpty()) {
                        foreach ($category->getArticles() as $article) {
                            if (static::discoverableArticles($article)) {
                                $rawCategories[] = [
                                    'id' => $category->getId(),
                                    'name' => $category->getName(),
                                ];
                                break;
                            }
                        }
                    }

                    foreach ($category->getChildren() as $subCategory) {
                        $newerCategories[] = $subCategory;
                    }
                }
            }

            $newCategories = $newerCategories;
        }

        $this->View()->assign(['success' => true, 'data' => $rawCategories]);
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
        $router = $this->createRouter($shop);

        /** @var Article[] $articles */
        $articles = $category->getArticles()->toArray();

        $filteredArticles = array_filter($articles, [Shopware_Controllers_Backend_HeptacomAmpOverviewData::class, 'discoverableArticles']);
        $result = [];

        foreach ($filteredArticles as &$article) {
            $result[] = [
                'name' => $article->getName(),
                'test_url' => $this->getUrl($router, 'detail', ['sArticle' => $article->getId(), 'amp' => 1]),
                'urls' => [
                    'mobile' => $this->getUrl($router, 'detail', ['sArticle' => $article->getId(), 'amp' => 1]),
                    'desktop' => $this->getUrl($router, 'detail', ['sArticle' => $article->getId()])
                ],
            ];
        }

        $this->View()->assign(['success' => true, 'data' => $result]);
    }

    /// TODO undo 4037b1c9780ed0faaa18192ee4157bf203981bd4 for customs and categories in cache warming
}
