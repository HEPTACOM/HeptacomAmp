<?php

use Doctrine\ORM\EntityRepository;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Components\Routing\Router;
use Shopware\Models\Article\Article;

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
     * @return Router
     */
    private function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getArticleIds
     */
    public function getArticleIdsAction()
    {
        $skip = $this->Request()->getParam('skip', 0);
        $take = $this->Request()->getParam('take', 50);

        $articles = $this->getArticleRepository()->
                           createQueryBuilder('articles')->
                           select([
                               'articles.id',
                               'articles.name'
                           ])->
                           addOrderBy('articles.id', 'ASC')->
                           setFirstResult($skip)->
                           setMaxResults($take)->
                           getQuery()->
                           getArrayResult();

        $router = $this->getRouter();

        foreach ($articles as &$article) {
            $article['url'] = $router->assemble([
                'module' => 'frontend',
                'controller' => 'detail',
                'action' => 'index',
                'sArticle' => $article['id'],
                'title' => $article['name'],
            ]);
        }

        $this->View()->assign(['success' => true, 'data' => $articles]);
    }
}
