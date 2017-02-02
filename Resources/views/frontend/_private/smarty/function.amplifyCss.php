<?php

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Shopware\Components\Logger;
use HeptacomAmp\Components\CssAmplifier;
use HeptacomAmp\Template\HeptacomAmp;

function smarty_function_amplifyCss(array $params, HeptacomAmp &$smarty)
{
    try {
        if (!array_key_exists('file', $params)) {
            throw new Exception('No valid path to a css file given.');
        }

        /** @var CssAmplifier $cssAmplifier */
        $cssAmplifier = Shopware()->Container()->get('heptacom_amp.components.css_amplifier');

        $path = realpath(implode(DIRECTORY_SEPARATOR, [
            Shopware()->DocPath(),
            substr($params['file'], strlen(Shopware()->Front()->Request()->getBaseUrl()))
        ]));

        $rawCss = file_get_contents($path);

        return $cssAmplifier->getAmpCss($rawCss);
    } catch (ServiceNotFoundException $exception) {
        /**@var Logger $pluginLogger */
        $pluginLogger = Shopware()->Container()->get('PluginLogger');
        $pluginLogger->error($exception->getMessage());
    } catch (Exception $exception) {
        /**@var Logger $pluginLogger */
        $pluginLogger = Shopware()->Container()->get('PluginLogger');
        $pluginLogger->warning($exception->getMessage());
    }
}
