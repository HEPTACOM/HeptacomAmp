<?php

namespace HeptacomAmp\Components;

use Exception;
use Shopware\Kernel;
use Shopware\Models\Shop\Shop;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Client;

/**
 * Class DispatchSimulator
 * @package HeptacomAmp\Components
 */
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
     * DispatchSimulator constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        /** @var Kernel $kernel */
        $kernel = $this->container->get('kernel');
        $this->client = new Client($kernel);
    }

    /**
     * @param Shop $shop
     * @param array $params
     * @return \Symfony\Component\DomCrawler\Crawler
     * @throws Exception
     */
    public function request(Shop $shop, array $params = [])
    {
        if ($shop === null) {
            throw new Exception('Shop cannot be null.');
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
