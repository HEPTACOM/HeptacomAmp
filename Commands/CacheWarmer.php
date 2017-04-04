<?php

namespace HeptacomAmp\Commands;

use HeptacomAmp\Components\DispatchSimulator;
use Shopware\Commands\ShopwareCommand;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Category\Category;
use Shopware\Models\Category\Repository as CategoryRepository;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Shop\Shop;
use Symfony\Component\Console\Helper\ProgressBar;
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
        /** @var DispatchSimulator $dispatchSimulator */
        $dispatchSimulator = $this->container->get('heptacom_amp.components.dispatch_simulator');

        /** @var ModelManager $modelManager */
        $modelManager = $this->container->get('Models');

        /** @var ShopRepository $shopRepository */
        $shopRepository = $modelManager->getRepository(Shop::class);

        /** @var Shop[] $shops */
        $shops = $shopRepository->findBy(['active' => true]);

        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = $modelManager->getRepository(Category::class);

        foreach ($shops as $shop) {
            $articleIds = $this->getArticleIds();

            $progress = new ProgressBar($output, count($articleIds));

            foreach ($articleIds as $articleId) {
                $dispatchSimulator->request($shop->getId(), ['controller' => 'detail', 'sArticle' => $articleId]);
                $progress->advance();
            }

            $progress->finish();
            $output->writeln('');
        }
    }

    private function getArticleIds()
    {
        return range(1, 10);
    }
}
