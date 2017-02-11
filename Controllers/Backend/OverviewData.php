<?php

use Doctrine\ORM\EntityRepository;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Components\Routing\Router;
use Shopware\Models\Article\Article;
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
            $article['url'] = str_replace('http://', 'https://', $router->assemble([
                'module' => 'frontend',
                'controller' => 'detail',
                'action' => 'index',
                'sArticle' => $article['id'],
            ]));
            $article['amp_url'] = str_replace('http://', 'https://', $router->assemble([
                'module' => 'frontend',
                'controller' => 'heptacomAmpDetail',
                'action' => 'index',
                'sArticle' => $article['id'],
            ]));
        }

        $this->View()->assign(['success' => true, 'data' => $articles]);
    }

    /**
     * Callable via /backend/HeptacomAmpOverviewData/getCustoms
     */
    public function getCustomsAction()
    {
        $skip = $this->Request()->getParam('skip', 0);
        $take = $this->Request()->getParam('take', 50);

        $customs = $this->getCustomRepository()->
                          createQueryBuilder('custom')->
                          select([
                              'custom.id',
                              'custom.description'
                          ])->
                          addOrderBy('custom.id', 'ASC')->
                          setFirstResult($skip)->
                          setMaxResults($take)->
                          getQuery()->
                          getArrayResult();

        $router = $this->getRouter();

        foreach ($customs as &$custom) {
            $custom['name'] = $custom['description'];
            $custom['url'] = str_replace('http://', 'https://', $router->assemble([
                'module' => 'frontend',
                'controller' => 'custom',
                'action' => 'index',
                'sCustom' => $custom['id'],
            ]));
            $custom['amp_url'] = str_replace('http://', 'https://', $router->assemble([
                'module' => 'frontend',
                'controller' => 'heptacomAmpCustom',
                'action' => 'index',
                'sCustom' => $custom['id'],
            ]));
        }

        $this->View()->assign(['success' => true, 'data' => $customs]);
    }
}
