<?php

use Shopware\Components\CSRFWhitelistAware;
use Shopware\Components\Logger;
use Shopware\Components\Routing\Context;
use Shopware\Components\Routing\Router;
use Shopware\Models\Article\Article;
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
     * @param Shop $shop
     * @return Router
     */
    private function createRouter(Shop $shop)
    {
        /** @var Router $router */
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
        if (is_null($article)) {
            return false;
        }

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

        return !is_null($article->getMainDetail()) && !empty($article->getMainDetail()->getNumber());
    }

    /**
     * @return array
     */
    private function getDiscoverableShops()
    {
        $sql = <<<EOL
SELECT DISTINCT shops.id, shops.name
FROM s_core_shops shops
INNER JOIN s_categories categories ON categories.path LIKE concat('%|',  shops.category_id, '|%') OR shops.category_id = categories.id
INNER JOIN s_articles_categories article_categories ON article_categories.categoryID = categories.id
INNER JOIN s_articles articles ON articles.id = article_categories.articleID
INNER JOIN s_articles_details details ON details.id = articles.main_detail_id
WHERE articles.active = 1
AND (articles.available_from IS NULL || articles.available_from <= CURRENT_TIMESTAMP)
AND (articles.available_to IS NULL || articles.available_to >= CURRENT_TIMESTAMP)
AND details.ordernumber IS NOT NULL AND TRIM(details.ordernumber) <> '';
EOL;

        try {
            $shops = $this->getModelManager()->getConnection()->executeQuery($sql)->fetchAll();

            foreach ($shops as &$shop) {
                $shop = [
                    'id' => (int) $shop['id'],
                    'name' => (string) $shop['name'],
                ];
            }

            return $shops;
        } catch (Exception $exception) {
            /** @var Logger $logger */
            $logger = $this->get('pluginlogger');
            $logger->error($exception->getMessage());

            return [];
        }
    }

    /**
     * @param Shop $shop
     * @return array
     */
    private function getDiscoverableCategories(Shop $shop)
    {
        $sql = <<<EOL
SELECT DISTINCT categories.id, categories.description name
FROM s_core_shops shops
INNER JOIN s_categories categories ON categories.path LIKE concat('%|',  shops.category_id, '|%')
INNER JOIN s_articles_categories article_categories ON article_categories.categoryID = categories.id
INNER JOIN s_articles articles ON articles.id = article_categories.articleID
INNER JOIN s_articles_details details ON details.id = articles.main_detail_id
WHERE articles.active = 1
AND (articles.available_from IS NULL || articles.available_from <= CURRENT_TIMESTAMP)
AND (articles.available_to IS NULL || articles.available_to >= CURRENT_TIMESTAMP)
AND details.ordernumber IS NOT NULL AND TRIM(details.ordernumber) <> ''
AND shops.id = :shopId;
EOL;

        try {
            $categories = $this->getModelManager()->getConnection()->executeQuery($sql, ['shopId' => $shop->getId()])->fetchAll();

            foreach ($categories as &$category) {
                $category = [
                    'id' => (int) $category['id'],
                    'name' => (string) $category['name'],
                ];
            }

            return $categories;
        } catch (Exception $exception) {
            /** @var Logger $logger */
            $logger = $this->get('pluginlogger');
            $logger->error($exception->getMessage());

            return [];
        }
    }

    private function getDiscoverableArticles(Category $category)
    {
        $sql = <<<EOL
SELECT DISTINCT article.id, article.name
FROM s_articles article
  INNER JOIN s_articles_categories sac ON article.id = sac.articleID
  INNER JOIN s_categories category ON category.id = sac.categoryID
  INNER JOIN s_articles_details detail ON detail.id = article.main_detail_id
WHERE article.active = 1
  AND (article.available_from IS NULL OR article.available_from <= CURRENT_TIMESTAMP)
  AND (article.available_to IS NULL OR article.available_to >= CURRENT_TIMESTAMP)
  AND detail.ordernumber IS NOT NULL AND TRIM(detail.ordernumber) <> ''
  AND category.id = :categoryId
EOL;

        try {
            $articles = $this->getModelManager()->getConnection()->executeQuery($sql, ['categoryId' => $category->getId()])->fetchAll();

            foreach ($articles as &$article) {
                $article = [
                    'id' => (int) $article['id'],
                    'name' => (string) $article['name'],
                ];
            }

            return $articles;
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
        if (empty($shops = $this->getDiscoverableShops())) {
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
        if (($shop = $this->getShopRepository()->find($this->Request()->getParam('shop'))) === null) {
            $this->View()->assign(['success' => false, 'data' => []]);
        } else {
            $this->View()->assign(['success' => true, 'data' => $this->getDiscoverableCategories($shop)]);
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
        $router = $this->createRouter($shop);

        $result = [];
        $articles = $this->getDiscoverableArticles($category);

        foreach ($articles as &$article) {
            $result[] = [
                'name' => $article['name'],
                'test_url' => $this->getUrl($router, 'detail', ['sArticle' => $article['id'], 'amp' => 1]),
                'urls' => [
                    'mobile' => $this->getUrl($router, 'detail', ['sArticle' => $article['id'], 'amp' => 1]),
                    'desktop' => $this->getUrl($router, 'detail', ['sArticle' => $article['id']])
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
