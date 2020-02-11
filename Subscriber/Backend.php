<?php declare(strict_types=1);

namespace HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use Shopware\Components\Form\Container\FieldSet;
use Shopware\Components\Form\Container\Tab;
use Shopware\Components\Form\Container\TabContainer;
use Shopware\Components\Form\Field\TextArea;

class Backend implements SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_HeptacomAmpOverview' => 'onGetBackendOverviewController',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_HeptacomAmpOverviewData' => 'onGetBackendOverviewDataController',
            'Theme_Configurator_Theme_Config_Created' => 'addThemeConfigurationField',
        ];
    }

    public function addThemeConfigurationField(Enlight_Event_EventArgs $args)
    {
        /** @var TabContainer $container */
        $container = $args->get('container');

        $ampTab = new Tab('heptacom_amp', 'AMP');
        $ampTab->setAttributes([
            'layout' => 'anchor',
            'autoScroll' => true,
            'padding' => '0',
            'defaults' => [
                'anchor' => '100%',
            ],
        ]);

        $fieldset = new FieldSet('global', 'Globale Konfiguration');
        $fieldset->setAttributes([
            'layout' => 'anchor',
            'autoScroll' => true,
            'padding' => '10',
            'margin' => '5',
            'defaults' => [
                'labelWidth' => 155,
                'anchor' => '100%',
            ],
        ]);

        $element = new TextArea('HeptacomAmpCustomCss');
        $element->setLabel('AMP Custom CSS');
        $element->setAttributes([
            'xtype' => 'textarea',
            'lessCompatible' => false,
        ]);

        $fieldset->addElement($element);
        $ampTab->addElement($fieldset);
        $container->addElement($ampTab);
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
