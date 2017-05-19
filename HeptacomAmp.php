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
    const CRONJOB_ACTION_CACHE_WARMER = 'Shopware_CronJob_HeptacomAmpCronjobCacheWarmer';

    /**
     * @var bool
     */
    private static $composerLoaded = false;

    /**
     * @param ActivateContext $context
     */
    public function activate(ActivateContext $context)
    {
        $this->handleCronJob($context);
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);

        parent::activate($context);
    }

    /**
     * @param DeactivateContext $context
     */
    public function deactivate(DeactivateContext $context)
    {
        $this->handleCronJob($context);
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);

        parent::deactivate($context);
    }

    /**
     * @param UpdateContext $context
     */
    public function update(UpdateContext $context)
    {
        $this->checkLicense();
        $this->handleCronJob($context);
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);

        parent::update($context);
    }

    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $this->checkLicense();
        $this->handleCronJob($context);

        parent::install($context);
    }

    public function uninstall(UninstallContext $context)
    {
        $this->handleCronJob($context);
        
        parent::uninstall($context);
    }

    private function handleCronJob(InstallContext $context)
    {
        /** @var Enlight_Components_Cron_Manager $cronManager */
        $cronManager = $this->container->get('cron');

        if (($cronJob = $cronManager->getJobByAction(static::CRONJOB_ACTION_CACHE_WARMER)) === null) {
            $cronJob = new Enlight_Components_Cron_Job([
                'name' => 'AMP CacheWarmer',
                'action' => static::CRONJOB_ACTION_CACHE_WARMER,
                'interval' => '86400',
            ]);
        }

        if ($context instanceof ActivateContext || $context instanceof DeactivateContext) {
            $cronJob->setActive($context instanceof ActivateContext);
        }

        if ($context instanceof UninstallContext) {
            $cronManager->deleteJob($cronJob);
        } else {
            $cronManager->updateJob($cronJob);
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Front_RouteShutdown' => 'autoloadComposer',
            'Shopware_Console_Add_Command' => 'autoloadComposer',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function autoloadComposer(Enlight_Event_EventArgs $args)
    {
        if (static::$composerLoaded === true) {
            return;
        }

        /** @var Enlight_Controller_Request_Request $request */
        $request = $args->get('request');

        if ($args->getName() === 'Shopware_Console_Add_Command' || $request->getParam('amp', 0)) {
            require_once implode(DIRECTORY_SEPARATOR, [$this->getPath(), 'vendor', 'autoload.php']);
        }
        static::$composerLoaded = true;
    }

    /**
     * checkLicense()-method for HeptacomAmp
     */
    public function checkLicense($throwException = true)
    {
        return true;
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
