<?php

use Doctrine\ORM\EntityRepository;
use Shopware\Components\CSRFWhitelistAware;
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
     * Callable via /backend/HeptacomAmpOverviewData/getArticleIds
     */
    public function getArticleIdsAction()
    {
        $skip = $this->Request()->getParam('skip', 0);
        $take = $this->Request()->getParam('take', 50);

        $mainArticleIds = $this->getArticleRepository()->
                                 createQueryBuilder('articles')->
                                 select('articles.mainDetailId')->
                                 addOrderBy('articles.id', 'ASC')->
                                 setFirstResult($skip)->
                                 setMaxResults($take)->
                                 getQuery()->
                                 getArrayResult();

        $this->View()->assign(['success' => true, 'data' => $mainArticleIds]);
    }
}
