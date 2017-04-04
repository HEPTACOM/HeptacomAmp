<?php

namespace HeptacomAmp\Components;

use Exception;
use Shopware\Components\Model\ModelManager;
use Shopware\Kernel;
use Shopware\Models\Shop\Repository;
use Shopware\Models\Shop\Shop;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Client;

class DispatchSimulator
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Client
     */
    private $client;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        /** @var Kernel $kernel */
        $kernel = $container->get('kernel');
        $this->client = new Client($kernel);
    }

    public function request($shopId, array $params = [])
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->container->get('Models');

        /** @var Repository $shopRepository */
        $shopRepository = $modelManager->getRepository(Shop::class);

        /** @var Shop $shop */
        $shop = $shopRepository->find($shopId);

        if ($shop === null) {
            throw new Exception(sprintf('Error: Cannot find shop by id %s. Got null instead.', $shopId));
        }

        $uri = implode([
            ($shop->getAlwaysSecure()) ? 'https://' : 'http://',
            ($shop->getAlwaysSecure() && $shop->getSecureHost()) ? $shop->getSecureHost() : $shop->getHost(),
            ($shop->getAlwaysSecure() && $shop->getSecureBasePath()) ? $shop->getSecureBasePath() : $shop->getBasePath(),
            ($shop->getAlwaysSecure() && $shop->getSecureBaseUrl()) ? $shop->getSecureBaseUrl() : $shop->getBaseUrl(),
        ]);

        $params = array_merge([
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index',
            'amp' => 1,
        ], $params);

        return $this->client->request('GET', $uri, $params);
    }
}
