<?php declare(strict_types=1);

namespace HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Action;
use Enlight_Controller_Front;
use Enlight_Event_EventArgs;
use Enlight_Event_EventManager;
use HeptacomAmp\Factory\ConfigurationFactory;
use HeptacomAmp\Reader\ConfigurationReader;
use ShopwarePlugins\SwagCustomProducts\Components\Services\TemplateServiceInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class Frontend implements SubscriberInterface
{
    /**
     * @var ConfigurationReader
     */
    private $configurationReader;

    /**
     * @var ConfigurationFactory
     */
    private $configurationFactory;

    /**
     * @var string
     */
    private $viewDirectory;

    /**
     * @param string $viewDirectory
     */
    public function __construct(ConfigurationReader $configurationReader, ConfigurationFactory $configurationFactory, $viewDirectory)
    {
        $this->configurationReader = $configurationReader;
        $this->configurationFactory = $configurationFactory;
        $this->viewDirectory = $viewDirectory;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend_Detail' => 'handleAmp',
            'Enlight_Controller_Action_PreDispatch_Frontend_Custom' => 'handleAmp',
            'Enlight_Controller_Action_PreDispatch_Frontend_Listing' => 'handleAmp',

            'Enlight_Controller_Action_PostDispatch_Frontend_HeptacomAmpDetail' => 'fakePostDispatch',
            'Enlight_Controller_Action_PostDispatch_Frontend_HeptacomAmpCustom' => 'fakePostDispatch',
            'Enlight_Controller_Action_PostDispatch_Frontend_HeptacomAmpListing' => 'fakePostDispatch',

            'Enlight_Controller_Dispatcher_ControllerPath_Backend_Overview' => 'getControllerBackendOverview',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_OverviewData' => 'getControllerBackendOverviewData',
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_HeptacomAmpCustom' => 'getControllerFrontendHeptacomAmpCustom',
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_HeptacomAmpDetail' => 'getControllerFrontendHeptacomAmpDetail',
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_HeptacomAmpListing' => 'getControllerFrontendHeptacomAmpListing',
            'Enlight_Controller_Dispatcher_ControllerPath_Widgets_HeptacomAmpListing' => 'getControllerWidgetsHeptacomAmpListing',

            'Enlight_Controller_Action_PostDispatchSecure_Widgets_Listing' => 'handleAmp',

            'Enlight_Controller_Front_DispatchLoopStartup' => 'legacyRedirect',

            'Enlight_Controller_Action_PostDispatchSecure_Frontend_HeptacomAmpDetail' => 'onFrontendHeptacomAmpDetailPostDispatch',
        ];
    }

    public function fakePostDispatch(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Event_EventManager $events */
        $events = Shopware()->Container()->get('events');

        $fakeArgs = clone $args;
        $fakeArgs->setName(str_replace('HeptacomAmp', '', $fakeArgs->getName()));

        $events->notify($fakeArgs->getName(), $fakeArgs);
    }

    public function getControllerWidgetsHeptacomAmpListing(Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Widgets/HeptacomAmpListing.php';
    }

    public function getControllerFrontendHeptacomAmpListing(Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Frontend/HeptacomAmpListing.php';
    }

    public function getControllerFrontendHeptacomAmpDetail(Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Frontend/HeptacomAmpDetail.php';
    }

    public function getControllerFrontendHeptacomAmpCustom(Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Frontend/HeptacomAmpCustom.php';
    }

    public function getControllerBackendOverviewData(Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Backend/OverviewData.php';
    }

    public function getControllerBackendOverview(Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Backend/Overview.php';
    }

    public function handleAmp(Enlight_Event_EventArgs $args)
    {
        $config = $this->configurationFactory->hydrate($this->configurationReader->read(Shopware()->Shop()->getId()));

        if (!$config->isActive()) {
            return;
        }

        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $request = $controller->Request();
        $view = $controller->View();

        if ($request->get('amp') == 1) {
            $controller->forward(
                $request->getActionName(),
                'HeptacomAmp' . ucfirst($request->getControllerName()),
                $request->getModuleName()
            );
        } else {
            $view->addTemplateDir($this->viewDirectory);
        }
    }

    public function onFrontendHeptacomAmpDetailPostDispatch(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $view = $controller->View();

        $assignedProduct = $view->getAssign('sArticle');
        $hasCustomProductsTemplate = true;

        try {
            /** @var TemplateServiceInterface $templateService */
            $templateService = Shopware()->Container()->get('custom_products.template_service');
            $customProductTemplate = $templateService->getTemplateByProductId($assignedProduct['articleID']);

            if (!$customProductTemplate) {
                $hasCustomProductsTemplate = false;
            }

            if (!$customProductTemplate['active']) {
                $hasCustomProductsTemplate = false;
            }
        } catch (ServiceNotFoundException $e) {
            $hasCustomProductsTemplate = false;
        }

        $assignedProduct['hasCustomProductsTemplate'] = $hasCustomProductsTemplate;
        $view->assign('sArticle', $assignedProduct);
    }

    public function legacyRedirect(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Front $front */
        $front = $args->get('subject');

        if ($front->Request()->getControllerName() == 'heptacomAmpDetail') {
            $front->Request()->setParam('heptacom_amp_redirect', true);
        }
    }
}
