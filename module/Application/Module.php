<?php
namespace Application;

use Zend\Mvc\MvcEvent;
use Application\EventListener\AuthListener;

class Module
{
	public function init($moduleManager)
	{
		$eventManager = $moduleManager->getEventManager();
		$sharedEventManager = $eventManager->getSharedManager();
		$sharedEventManager->attach('Zend\Mvc\Application', 'dispatch', array($this, 'setWebsiteId'), 1000);
		
		$authListener = new AuthListener();
		//$eventManager->attach($authListener);
	}
	
    public function getConfig()
    {
    	return include __DIR__ . '/config/module.config.php';
    }
    
	public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__	=> __DIR__ . '/src/' . __NAMESPACE__,
					'WxDocument'	=> BASE_PATH . '/inc/WxDocument'
				)
            ),
        );
    }
    
    public function setWebsiteId(MvcEvent $e)
    {
    	$websiteId = $e->getRouteMatch()->getParam('websiteId');
    	$sm = $e->getApplication()->getServiceManager();
    	$cmsSite = $sm->get('Application\Service\CmsSiteService');
    	$cmsSite->setWebsiteId($websiteId);
    }
}