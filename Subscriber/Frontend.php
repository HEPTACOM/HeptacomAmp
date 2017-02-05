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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onFrontendDetailPostDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_HeptacomAmpDetail' => 'onFrontendHeptacomAmpDetailPostDispatch',
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_HeptacomAmpDetail' => 'onGetControllerPathFrontendDetail',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onFrontendDetailPostDispatch(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $request = $controller->Request();
        $view = $controller->View();

        $view->addTemplateDir(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Resources', 'views']));

        if ($request->get('amp') == 1) {
            $sArticle = (int) $request->get('sArticle');

            $controller->redirect([
                'controller' => 'heptacomAmpDetail',
                'action' => 'index',
                'sArticle' => $sArticle,
            ]);
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

    /**
     * @param Enlight_Event_EventArgs $args
     * @return string
     */
    public function onGetControllerPathFrontendDetail(Enlight_Event_EventArgs $args)
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Frontend', 'HeptacomAmpDetail.php']);
    }
}
