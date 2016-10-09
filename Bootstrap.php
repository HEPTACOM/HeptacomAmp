<?php

class Shopware_Plugins_Frontend_HeptacomAmp_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    public function getVersion() {
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
