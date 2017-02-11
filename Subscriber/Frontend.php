<?php

namespace HeptacomAmp\Subscriber;

use Enlight_Controller_Action;
use Enlight_Event_EventArgs;
use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use ShopwarePlugins\SwagCustomProducts\Components\Services\TemplateServiceInterface;

class Frontend implements SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'handleAmp',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Custom' => 'handleAmp',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'handleAmp',

            'Enlight_Controller_Action_PostDispatchSecure_Widgets_Listing' => 'handleAmp',

            'Enlight_Controller_Action_PostDispatchSecure_Frontend_HeptacomAmpDetail' => 'onFrontendHeptacomAmpDetailPostDispatch',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function handleAmp(Enlight_Event_EventArgs $args)
    {
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
            $view->addTemplateDir(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Resources', 'views']));
        }
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
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
}
