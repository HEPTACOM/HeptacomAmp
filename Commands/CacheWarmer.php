<?php

namespace HeptacomAmp\Commands;

use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheWarmer extends ShopwareCommand
{
    protected function configure()
    {
        $this->setName('heptacom:amp:cache:generate')
            ->setDescription('Generate cache for AMP pages.')
            ->setHelp('The <info>%command.name%</info> generates a cached copy of the AMP pages.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
