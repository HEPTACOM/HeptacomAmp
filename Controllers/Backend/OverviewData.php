<?php

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Components\Routing\Router;
use Shopware\Models\Article\Article;
use Shopware\Models\Category\Category;
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
            'getArticleIds',
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
     * @return Router
     */
    private function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * @param string $controller
     * @param string[] $params
     * @param string $action
     * @return string
     */
    private function getUrl($controller, array $params, $action = 'index')
    {
        return str_replace(
            'http://',
            'https://',
            $this->getRouter()->assemble(
                array_merge([
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
        return $article->getCategories()->count() > 0;
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getArticleIds
     */
    public function getArticleIdsAction()
    {
        $skip = $this->Request()->getParam('skip', 0);
        $take = $this->Request()->getParam('take', 50);

        /** @var Article[] $articles */
        $articles = $this->getArticleRepository()
                         ->createQueryBuilder('articles')
                         ->addOrderBy('articles.id', 'ASC')
                         ->setFirstResult($skip)
                         ->setMaxResults($take)
                         ->getQuery()
                         ->getResult(Query::HYDRATE_OBJECT);

        $filteredArticles = array_filter($articles, [Shopware_Controllers_Backend_HeptacomAmpOverviewData::class, 'discoverableArticles']);
        $result = [];

        foreach ($filteredArticles as &$article) {
            $result[] = [
                'name' => $article->getName(),
                'test_url' => $this->getUrl('heptacomAmpDetail', ['sArticle' => $article->getId()]),
                'urls' => [
                    'mobile' => $this->getUrl('heptacomAmpDetail', ['sArticle' => $article->getId()]),
                    'desktop' => $this->getUrl('detail', ['sArticle' => $article->getId()])
                ],
            ];
        }

        $this->View()->assign(['success' => true, 'data' => $result, 'count' => count($articles)]);
    }

    /**
     * @param Category $category
     * @return bool
     */
    private static function discoverableCategories(Category $category)
    {
        return !empty($category->getPath()) && $category->getActive();
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getCategories
     */
    public function getCategoriesAction()
    {
        $skip = $this->Request()->getParam('skip', 0);
        $take = $this->Request()->getParam('take', 50);

        /** @var Category[] $categories */
        $categories = $this->getCategoryRepository()->
                             createQueryBuilder('category')->
                             addOrderBy('category.id', 'ASC')->
                             setFirstResult($skip)->
                             setMaxResults($take)->
                             getQuery()->
                             getResult(Query::HYDRATE_OBJECT);

        $filterCategories = array_filter($categories, [Shopware_Controllers_Backend_HeptacomAmpOverviewData::class, 'discoverableCategories']);
        $result = [];

        foreach ($filterCategories as &$category) {
            $result[] = [
                'name' => $category->getName(),
                'test_url' => $this->getUrl('heptacomAmpListing', ['sCategory' => $category->getId(), 'sViewport' => 'cat', 'p' => 1]),
                'urls' => [
                    'mobile' => $this->getUrl('heptacomAmpListing', ['sCategory' => $category->getId(), 'sViewport' => 'cat', 'p' => 1]),
                    'desktop' => $this->getUrl('listing', ['sCategory' => $category->getId(), 'sViewport' => 'cat', 'p' => 1])
                ]
            ];
        }

        $this->View()->assign(['success' => true, 'data' => $result, 'count' => count($categories)]);
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getCustoms
     */
    public function getCustomsAction()
    {
        $skip = $this->Request()->getParam('skip', 0);
        $take = $this->Request()->getParam('take', 50);

        /** @var Site[] $customs */
        $customs = $this->getCustomRepository()->
                          createQueryBuilder('custom')->
                          addOrderBy('custom.id', 'ASC')->
                          setFirstResult($skip)->
                          setMaxResults($take)->
                          getQuery()->
                          getResult(Query::HYDRATE_OBJECT);

        $result = [];
        foreach ($customs as &$custom) {
            $result[] = [
                'name' => $custom->getDescription(),
                'test_url' => $this->getUrl('heptacomAmpCustom', ['sCustom' => $custom->getId()]),
                'urls' => [
                    'mobile' => $this->getUrl('heptacomAmpCustom', ['sCustom' => $custom->getId()]),
                    'desktop' => $this->getUrl('custom', ['sCustom' => $custom->getId()]),
                ]
            ];
        }

        $this->View()->assign(['success' => true, 'data' => $result, 'count' => count($customs)]);
    }
}
