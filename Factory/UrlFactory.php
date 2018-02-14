<?php

namespace HeptacomAmp\Factory;

use HeptacomAmp\Struct\UrlStruct;
use Shopware\Bundle\StoreFrontBundle\Struct\ListProduct;
use Shopware\Components\Routing\Context;
use Shopware\Components\Routing\Router;
use Shopware\Models\Article\Detail;
use Shopware\Models\Category\Category;
use Shopware\Models\Shop\Shop;
use Shopware_Components_Config;

/**
 * Class UrlFactory
 * @package HeptacomAmp\Factory
 */
class UrlFactory
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Shopware_Components_Config
     */
    private $config;

    /**
     * UrlFactory constructor.
     * @param Router $router
     * @param Shopware_Components_Config $config
     */
    public function __construct(Router $router, Shopware_Components_Config $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * @param UrlStruct $urlStruct
     * @return array
     */
    public function dehydrate(UrlStruct $urlStruct)
    {
        return [
            'id' => $urlStruct->getId(),
            'name' => $urlStruct->getName(),
            'urls' => $urlStruct->getUrls()
        ];
    }

    /**
     * @param Shop $shop
     * @return UrlStruct
     */
    public function hydrateFromShop(Shop $shop)
    {
        return (new UrlStruct())
            ->setId($shop->getId())
            ->setName($shop->getName())
            ->setUrls([
                'canonical' => $this->getShopUrl($shop),
            ]);
    }

    /**
     * @param Shop $shop
     * @return string
     */
    protected function getShopUrl(Shop $shop)
    {
        return $this->getUrl($shop, 'frontend', 'index', 'index');
    }

    /**
     * @param Shop $shop
     * @param Category $category
     * @return UrlStruct
     */
    public function hydrateFromCategory(Shop $shop, Category $category)
    {
        return (new UrlStruct())
            ->setId($category->getId())
            ->setName($category->getName())
            ->setUrls([
                'canonical' => $this->getCategoryUrl($shop, $category, false),
                'amp' => $this->getCategoryUrl($shop, $category, true),
            ]);
    }

    /**
     * @param Shop $shop
     * @param Category $category
     * @param bool $amp
     * @return string
     */
    protected function getCategoryUrl(Shop $shop, Category $category, $amp)
    {
        $extra = [
            'sCategory' => $category->getId(),
        ];

        if ($amp) {
            $extra = array_merge($extra, [
                'amp' => 1,
            ]);
        }

        return $this->getUrl($shop, 'frontend', 'listing', 'index', $extra);
    }

    /**
     * @param Shop $shop
     * @param ListProduct $listProduct
     * @return UrlStruct
     */
    public function hydrateFromProduct(Shop $shop, ListProduct $listProduct)
    {
        return (new UrlStruct())
            ->setId($listProduct->getId())
            ->setName($listProduct->getName())
            ->setUrls([
                'canonical' => $this->getProductUrl($shop, $listProduct, false),
                'amp' => $this->getProductUrl($shop, $listProduct, true),
            ]);
    }

    /**
     * @param Shop $shop
     * @param ListProduct $listProduct
     * @param bool $amp
     * @return string
     */
    protected function getProductUrl(Shop $shop, ListProduct $listProduct, $amp)
    {
        $extra = [
            'sArticle' => $listProduct->getId(),
        ];

        if ($amp) {
            $extra = array_merge($extra, [
                'amp' => 1,
            ]);
        }

        return $this->getUrl($shop, 'frontend', 'detail', 'index', $extra);
    }

    /**
     * @param Shop $shop
     * @param $module
     * @param $controller
     * @param $action
     * @param array $params
     * @return string
     */
    public function getUrl(Shop $shop, $module, $controller, $action, $params = [])
    {
        return str_replace(
            'http://',
            'https://',
            $this->createRouter($shop)->assemble(array_merge([
                'module' => $module,
                'controller' => $controller,
                'action' => $action
            ], $params)));
    }

    /**
     * @param Shop $shop
     * @return Router
     */
    protected function createRouter(Shop $shop)
    {
        if ($shop->getBaseUrl() === null) {
            $shop->setBaseUrl($shop->getBasePath());
        }

        // Register the shop (we're to soon)
        $this->config->setShop($shop);

        $context = $this->router->getContext();
        $newContext = Context::createFromShop($shop, $this->config);
        // Reuse the host
        if ($newContext->getHost() === null) {
            $newContext->setHost($context->getHost());
            $newContext->setBaseUrl($context->getBaseUrl());
            // Reuse https
            if (method_exists($newContext, 'setSecureBaseUrl') && !$newContext->isSecure()) {
                $newContext->setSecure($context->isSecure());
                $newContext->setSecureBaseUrl($context->getSecureBaseUrl());
            }
        }
        $this->router->setContext($newContext);
        return $this->router;
    }
}
