<?php

namespace HeptacomAmp\Commands;

use HeptacomAmp\Components\CacheWarmer as CacheWarmerService;
use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CacheWarmer
 * @package HeptacomAmp\Commands
 */
class CacheWarmer extends ShopwareCommand
{
    protected function configure()
    {
        $this->setName('heptacom:amp:cache:generate')
            ->setDescription('Generate cache for AMP pages.')
            ->setHelp('The <info>%command.name%</info> generates a cached copy of the AMP pages.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CacheWarmerService $cacheWarmer */
        $cacheWarmer = $this->container->get('heptacom_amp.components.cache_warmer');

        $cacheWarmer->injectOutput($output);
        $cacheWarmer->warmUp();
    }
}
