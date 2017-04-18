<?php

namespace HeptacomAmp;

use Enlight_Components_Cron_Job;
use Enlight_Components_Cron_Manager;
use Enlight_Controller_Request_Request;
use Enlight_Event_EventArgs;
use Exception;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Shopware_Components_License;

class HeptacomAmp extends Plugin
{
    /**
     * @param ActivateContext $context
     */
    public function activate(ActivateContext $context)
    {
        /** @var Enlight_Components_Cron_Manager $cronManager */
        $cronManager = $this->container->get('cron');

        $cronJob = $cronManager->getJobByAction('Shopware_CronJob_HeptacomAmpCronjobCacheWarmer');
        if ($cronJob !== null) {
            $cronJob->setActive(true);
            $cronManager->updateJob($cronJob);
        }

        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    /**
     * @param DeactivateContext $context
     */
    public function deactivate(DeactivateContext $context)
    {
        /** @var Enlight_Components_Cron_Manager $cronManager */
        $cronManager = $this->container->get('cron');

        $cronJob = $cronManager->getJobByAction('Shopware_CronJob_HeptacomAmpCronjobCacheWarmer');
        if ($cronJob !== null) {
            $cronJob->setActive(false);
            $cronManager->updateJob($cronJob);
        }

        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    /**
     * @param UpdateContext $context
     */
    public function update(UpdateContext $context)
    {
        $this->checkLicense();
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $this->checkLicense();

        /** @var Enlight_Components_Cron_Manager $cronManager */
        $cronManager = $this->container->get('cron');

        $cronJob = new Enlight_Components_Cron_Job([
            'name' => 'AMP CacheWarmer',
            'action' => 'Shopware_CronJob_HeptacomAmpCronjobCacheWarmer',
            'interval' => '86400',
            'data' => '',
        ]);
        $cronManager->addJob($cronJob);

        parent::install($context);
    }

    public function uninstall(UninstallContext $context)
    {
        /** @var Enlight_Components_Cron_Manager $cronManager */
        $cronManager = $this->container->get('cron');

        $cronJob = $cronManager->getJobByAction('Shopware_CronJob_HeptacomAmpCronjobCacheWarmer');
        if ($cronJob !== null) {
            $cronManager->deleteJob($cronJob);
        }

        parent::uninstall($context);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Front_RouteShutdown' => 'autoloadComposer',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function autoloadComposer(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Request_Request $request */
        $request = $args->get('request');

        if ($request->getParam('amp', 0)) {
            require_once implode(DIRECTORY_SEPARATOR, [$this->getPath(), 'HeptacomAutoloader.php']);
        }
    }

    /**
     * checkLicense()-method for HeptacomAmp
     */
    public function checkLicense($throwException = true)
    {
        try {
            /** @var $l Shopware_Components_License */
            $l = Shopware()->License();
        } catch (\Exception $e) {
            if ($throwException) {
                throw new Exception('The license manager has to be installed and active');
            } else {
                return false;
            }
        }

        try {
            static $r, $module = 'HeptacomAmp';
            if(!isset($r)) {
                $s = base64_decode('uZv6Qx9VMVu7Arx62pFWKkXIPpg=');
                $c = base64_decode('FtdAlOEwfWjkSxNe18BfbPOi1zQ=');
                $r = sha1(uniqid('', true), true);
                $i = $l->getLicense($module, $r);
                $t = $l->getCoreLicense();
                $u = strlen($t) === 20 ? sha1($t . $s . $t, true) : 0;
                $r = $i === sha1($c. $u . $r, true);
            }
            if (!$r && $throwException) {
                throw new Exception('License check for module "' . $module . '" has failed.');
            }
            return $r;
        } catch (Exception $e) {
            if ($throwException) {
                throw new Exception('License check for module "' . $module . '" has failed.');
            } else {
                return false;
            }
        }
    }
}
