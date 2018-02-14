<?php

namespace HeptacomAmp\Factory;

use HeptacomAmp\Struct\UrlStruct;
use Shopware\Bundle\StoreFrontBundle\Struct\ListProduct;
use Shopware\Components\Routing\Context;
use Shopware\Components\Routing\Router;
use Shopware\Models\Category\Category;
use Shopware\Models\Shop\Shop;
use Shopware_Components_Config;

/**
 * Class UrlFactory
 * @package HeptacomAmp\Factory
 */
class UrlFactory
{
    const URL_MODE_CANONICAL = 0;

    const URL_MODE_AMP = 1;

    const URL_MODE_RAW_AMP = 2;

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
     * @param int $urlMode
     * @param array $extra
     * @return array
     */
    protected static function appendUrlMode($urlMode, $extra)
    {
        switch ($urlMode) {
            /** @noinspection PhpMissingBreakStatementInspection */
            case self::URL_MODE_RAW_AMP:
                $extra['kskAmpRaw'] = 1;
            case self::URL_MODE_AMP:
                $extra['amp'] = 1;
                break;
        }

        return $extra;
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
                'canonical' => $this->getCategoryUrl($shop, $category, self::URL_MODE_CANONICAL),
                'amp' => $this->getCategoryUrl($shop, $category, self::URL_MODE_AMP),
                'debug' => $this->getCategoryUrl($shop, $category, self::URL_MODE_RAW_AMP),
            ]);
    }

    /**
     * @param Shop $shop
     * @param Category $category
     * @param int $urlMode
     * @return string
     */
    protected function getCategoryUrl(Shop $shop, Category $category, $urlMode)
    {
        $extra = [
            'sCategory' => $category->getId(),
        ];

        return $this->getUrl($shop, 'frontend', 'listing', 'index', self::appendUrlMode($urlMode, $extra));
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
                'canonical' => $this->getProductUrl($shop, $listProduct, self::URL_MODE_CANONICAL),
                'amp' => $this->getProductUrl($shop, $listProduct, self::URL_MODE_AMP),
                'debug' => $this->getProductUrl($shop, $listProduct, self::URL_MODE_RAW_AMP),
            ]);
    }

    /**
     * @param Shop $shop
     * @param ListProduct $listProduct
     * @param int $urlMode
     * @return string
     */
    protected function getProductUrl(Shop $shop, ListProduct $listProduct, $urlMode)
    {
        $extra = [
            'sArticle' => $listProduct->getId(),
        ];

        return $this->getUrl($shop, 'frontend', 'detail', 'index', self::appendUrlMode($urlMode, $extra));
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
            if (!$newContext->isSecure()) {
                $newContext->setSecure($context->isSecure());
                $newContext->setSecureBaseUrl($context->getSecureBaseUrl());
            }
        }
        $this->router->setContext($newContext);
        return $this->router;
    }
}
