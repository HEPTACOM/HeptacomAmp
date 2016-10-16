<?php

class Shopware_Plugins_Frontend_HeptacomAmp_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
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

    public function getVersion()
    {
        $info = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR .'plugin.json'), true);
        if ($info) {
            return $info['currentVersion'];
        } else {
            throw new Exception('The plugin has an invalid version file.');
        }
    }

    public function getLabel()
    {
        return 'AMP Detailseite';
    }

    public function getInfo()
    {
        $info = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR .'plugin.json'), true);

        return array(
            'version' => $this->getVersion(),
            'label' => $this->getLabel(),
            'supplier' => $info['author'],
            'author' => $info['author'],
            'description' => $info['description']['de'],
            'link' => 'https://www.heptacom.de'
        );
    }

    public function uninstall()
    {
        return true;
    }

    public function update($oldVersion)
    {
        return true;
    }

    public function install()
    {
        $this->subscribeEvent(
            'Enlight_Controller_Front_DispatchLoopStartup',
            'onStartDispatch'
        );

        return true;
    }

    public function enable()
    {
       return [
           'success' => true,
           'invalidateCache' => ['template', 'theme']
       ];
    }

    /**
     * This callback function is triggered at the very beginning of the dispatch process and allows
     * us to register additional events on the fly. This way you won't ever need to reinstall you
     * plugin for new events - any event and hook can simply be registerend in the event subscribers
     */
    public function onStartDispatch(Enlight_Event_EventArgs $args)
    {
        $this->registerMyComponents();

        $subscribers = array(
            new \Shopware\HeptacomAmp\Subscriber\Detail()
        );

        foreach ($subscribers as $subscriber) {
            $this->Application()->Events()->addSubscriber($subscriber);
        }
    }

    public function registerMyComponents()
    {
        $this->Application()->Loader()->registerNamespace(
            'Shopware\HeptacomAmp',
            $this->Path()
        );
    }
}
