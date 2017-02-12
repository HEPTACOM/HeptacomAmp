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
}
