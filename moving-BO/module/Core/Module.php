<?php
namespace Core;

use Collection\View\Helper\formatForm;
use Collection\View\Helper\DatatableWidget;
use Parcours\View\Helper\BoutonSceneWidget;
use Parcours\View\Helper\TransitionWidget;
use Parcours\View\Helper\TitreSousParcoursWidget;
use Parcours\View\Helper\TransitionsSecondairesWidget;


class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // the array key here is the name you will call the view helper by in your view scripts
                /*'adminEmail' => function($sm) {
                    $locator = $sm->getServiceLocator(); // $sm is the view helper manager, so we need to fetch the main service manager
                    return new adminEmail($locator->get('Doctrine\ORM\EntityManager'));
                },*/
                'DatatableWidget' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new DatatableWidget();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'BoutonSceneWidget' => function ($helperPluginManager) {
                	$viewHelper = new BoutonSceneWidget();
                	return $viewHelper;
                },
                'TransitionWidget' => function ($helperPluginManager) {
                	$viewHelper = new TransitionWidget();
                	return $viewHelper;
                },
                'TitreSousParcoursWidget' => function ($helperPluginManager) {
                	$viewHelper = new TitreSousParcoursWidget();
                	return $viewHelper;
                },
                'TransitionsSecondairesWidget' => function ($helperPluginManager) {
                	$viewHelper = new TransitionsSecondairesWidget();
                	return $viewHelper;
                },
            ),
        );
    }
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'Collection' => __DIR__ . '/src/Collection',
                    'Parcours' => __DIR__ . '/src/Parcours'
                ),
            ),
        );
    }
}
