<?php

namespace HeptacomAmp\Services\Searcher;

use HeptacomAmp\Factory\ConfigurationFactory;
use HeptacomAmp\Factory\UrlFactory;
use HeptacomAmp\Reader\ConfigurationReader;
use HeptacomAmp\Struct\UrlStruct;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Shop\Shop;

/**
 * Class UrlSearcher
 * @package HeptacomAmp\Services\Searcher
 */
class UrlSearcher
{
    /**
     * @var ConfigurationFactory
     */
    private $configurationFactory;

    /**
     * @var ConfigurationReader
     */
    private $configurationReader;

    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var UrlFactory
     */
    private $urlFactory;

    /**
     * UrlSearcher constructor.
     * @param ConfigurationFactory $configurationFactory
     * @param ConfigurationReader $configurationReader
     * @param ShopRepository $shopRepository
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        ConfigurationFactory $configurationFactory,
        ConfigurationReader $configurationReader,
        ShopRepository $shopRepository,
        UrlFactory $urlFactory
    ) {
        $this->configurationFactory = $configurationFactory;
        $this->configurationReader = $configurationReader;
        $this->shopRepository = $shopRepository;
        $this->urlFactory = $urlFactory;
    }

    /**
     * @return UrlStruct[]
     */
    public function findShops()
    {
        // TODO get only active ones
        /** @var Shop[] $shops */
        $shops = $this->shopRepository->findAll();
        $shops = array_filter($shops, [$this, 'hasShopAmpEnabled']);
        return array_map([$this->urlFactory, 'hydrateFromShop'], $shops);
    }

    /**
     * @param Shop $shop
     * @return bool
     */
    protected function hasShopAmpEnabled(Shop $shop)
    {
        return $this->configurationFactory->hydrate($this->configurationReader->read($shop->getId()))->isActive();
    }
}
