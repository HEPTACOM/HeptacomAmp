<?php

namespace HeptacomAmp\Components;

use Shopware\Components\Logger;
use Shopware\Components\Theme\Compiler;
use Shopware\Components\Theme\PathResolver;
use Shopware\Models\Shop;

class ThemeCompilerDecorator extends Compiler
{
    public function compileLess($timestamp, Shop\Template $template, Shop\Shop $shop)
    {
        parent::compileLess($timestamp, $template, $shop);

        /** @var PathResolver $pathResolver */
        $pathResolver = Shopware()->Container()->get('theme_path_resolver');
        $file = $pathResolver->getCssFilePath($shop, $timestamp);

        /** @var Logger $logger */
        $logger = Shopware()->Container()->get('PluginLogger');
        $logger->info(sprintf('CSS file location for Shop %s: %s', $shop->getId(), $file));
    }
}
