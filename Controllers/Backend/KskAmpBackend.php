<?php

use Doctrine\ORM\QueryBuilder;
use HeptacomAmp\Components\PluginDependencies;
use Shopware\Components\Api\Exception\ParameterMissingException;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Components\Routing\Context;
use Shopware\Components\Routing\Router;
use Shopware\Models\Article\Article;
use Shopware\Models\Category\Category;
use Shopware\Models\Category\Repository;
use Shopware\Models\Shop\Shop;

/**
 * Class Shopware_Controllers_Backend_KskAmpBackend
 */
class Shopware_Controllers_Backend_KskAmpBackend extends Shopware_Controllers_Api_Rest implements CSRFWhitelistAware
{
    /**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return [
            'getDependencies',
            'getCategories',
            'getArticlesByShopCategory',
        ];
    }

    /**
     * @return array
     */
    private function getDependencies()
    {
        return PluginDependencies::instance()->getDependencies();
    }

    /**
     * Callable via /backend/KskAmpBackend/getDependencies
     */
    public function getDependenciesAction()
    {
        $this->View()->assign([
            'success' => false,
            'data' => $this->getDependencies(),
        ]);
    }

    /**
     * @param Category $category
     * @return array
     */
    private function hydrateCategory(Category $category)
    {
        $result = [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];

        if (!$category->getChildren()->isEmpty()) {
            $result['categories'] = array_map([$this, 'hydrateCategory'], $category->getChildren()->toArray());
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getCategories()
    {
        /** @var Repository $categoryRepository */
        $categoryRepository = $this->getModelManager()->getRepository(Category::class);
        return array_map([$this, 'hydrateCategory'], $categoryRepository->findBy(['parent' => null]));
    }

    /**
     * Callable via /backend/KskAmpBackend/getCategories
     */
    public function getCategoriesAction()
    {
        $this->View()->assign([
            'success' => false,
            'data' => $this->getCategories(),
        ]);
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

        if ($shop->getBaseUrl() === null) {
            $shop->setBaseUrl($shop->getBasePath());
        }

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
    private static function getUrl(Router $router, $controller, array $params, $action = 'index')
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
     * @param $shopId
     * @param $categoryId
     * @param $lastArticleId
     * @return array
     */
    private function getArticlesByShopCategory($shopId, $categoryId, $lastArticleId = null)
    {
        $result = [];

        /** @var QueryBuilder $qb */
        $qb = $this->getModelManager()
            ->getRepository(Article::class)
            ->createQueryBuilder('article');

        $qb = $qb->orderBy('article.id')
            ->setMaxResults(20)
            ->innerJoin('article.categories', 'category')
            ->andWhere($qb->expr()->eq('category.id', $categoryId));

        if (!empty($lastArticleId)) {
            $qb = $qb->andWhere($qb->expr()->gt('article.id', $lastArticleId));
        }

        /** @var Shop $shop */
        $shop = $this->getModelManager()->getRepository(Shop::class)->find($shopId);
        $router = $this->createRouter($shop);

        /** @var Article $article */
        foreach ($qb->getQuery()->getResult() as &$article) {
            $result[] = [
                'id' => $article->getId(),
                'name' => $article->getName(),
                'ampUrl' => static::getUrl($router, 'detail', ['sArticle' => $article->getId(), 'amp' => 1]),
                'canonicalUrl' => static::getUrl($router, 'detail', ['sArticle' => $article->getId()]),
            ];
        }

        return $result;
    }

    /**
     * Callable via /backend/KskAmpBackend/getArticlesByShopCategory
     */
    public function getArticlesByShopCategoryAction()
    {
        $lastArticleId = $this->Request()->getParam('last_article');

        if (empty($shopId = $this->Request()->getParam('shop'))) {
            throw new ParameterMissingException('shop');
        }

        if (empty($categoryId = $this->Request()->getParam('category'))) {
            throw new ParameterMissingException('category');
        }

        $this->View()->assign([
            'success' => false,
            'data' => $this->getArticlesByShopCategory($shopId, $categoryId, $lastArticleId),
        ]);
    }
}