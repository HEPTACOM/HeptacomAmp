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

    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var Repository
     */
    private $shopRepository;

    public function __construct(ContainerInterface $container, ModelManager $modelManager)
    {
        $this->container = $container;

        /** @var Kernel $kernel */
        $kernel = $this->container->get('kernel');
        $this->client = new Client($kernel);

        $this->modelManager = $modelManager;
        $this->shopRepository = $this->modelManager->getRepository(Shop::class);
    }

    public function request($shopId, array $params = [])
    {
        /** @var Shop $shop */
        $shop = $this->shopRepository->find($shopId);

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
