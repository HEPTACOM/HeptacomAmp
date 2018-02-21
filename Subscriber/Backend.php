<?php

namespace HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use Shopware\Components\Form\Container\FieldSet;
use Shopware\Components\Form\Container\Tab;
use Shopware\Components\Form\Container\TabContainer;
use Shopware\Components\Form\Field\TextArea;

/**
 * Class Backend
 * @package HeptacomAmp\Subscriber
 */
class Backend implements SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return  [
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_HeptacomAmpOverview' => 'onGetBackendOverviewController',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_HeptacomAmpOverviewData' => 'onGetBackendOverviewDataController',
            'Theme_Configurator_Theme_Config_Created' => 'addThemeConfigurationField',
        ];
    }

    public function addThemeConfigurationField(Enlight_Event_EventArgs $args)
    {
        /** @var TabContainer $container */
        $container = $args->get('container');

        /** @var Tab[] $tabs */
        $tabs = $container->getElements();

        foreach ($tabs as $tab) {
            if ($tab->getName() !== 'responsiveMain') {
                continue;
            }

            $element = new TextArea('HeptacomAmpCustomCss');
            $element->setLabel('AMP Custom CSS');
            $element->setAttributes([
                'xtype' => 'textarea',
                'lessCompatible' => false,
            ]);

            foreach ($tab->getElements() as $fieldset) {
                if (!$fieldset instanceof FieldSet) {
                    continue;
                }

                if ($fieldset->getName() === 'responsiveGlobal') {
                    $fieldset->addElement($element);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function onGetBackendOverviewController()
    {
        return join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Backend', 'Overview.php']);
    }

    /**
     * @return string
     */
    public function onGetBackendOverviewDataController()
    {
        return join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Backend', 'OverviewData.php']);
    }
}
