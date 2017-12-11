<?php

namespace HeptacomAmp\Reader;

use HeptacomAmp\HeptacomAmp;
use InvalidArgumentException;
use Shopware\Components\Plugin\ConfigReader;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Shop\Shop;

/**
 * Class ConfigurationReader
 * @package HeptacomAmp\Reader
 */
class ConfigurationReader
{
    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var ConfigReader
     */
    private $configReader;

    /**
     * ConfigurationReader constructor.
     * @param ShopRepository $shopRepository
     * @param ConfigReader $configReader
     */
    public function __construct(ShopRepository $shopRepository, ConfigReader $configReader)
    {
        $this->shopRepository = $shopRepository;
        $this->configReader = $configReader;
    }

    /**
     * @param int $shopId
     * @return array
     */
    public function read($shopId)
    {
        if (is_null($shopId)) {
            throw new InvalidArgumentException('$shopId is null');
        }

        if (!is_int($shopId)) {
            throw new InvalidArgumentException('$shopId is not an int');
        }

        /** @var Shop $shop */
        $shop = $this->shopRepository->find($shopId);

        if (is_null($shop)) {
            // TODO specialize exception
            throw new InvalidArgumentException('$shop by $shopId is null');
        }

        return $this->configReader->getByPluginName(HeptacomAmp::PLUGIN_NAME, $shop);
    }
}
