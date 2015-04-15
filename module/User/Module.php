<?php
namespace User;

use Zend\Mvc\MvcEvent;

class Module
{
	public function init($moduleManager)
	{
		$eventManager = $moduleManager->getEventManager();
		$sharedEventManager = $eventManager->getSharedManager();
		
		//$sharedEventManager->attach(__NAMESPACE__, 'dispatch', array($this, 'userAuth'), 100);
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
					__NAMESPACE__	=> __DIR__ . '/src/' . __NAMESPACE__
				)
            ),
        );
    }
    
    public function userAuth(MvcEvent $e)
    {
    	
    }
}