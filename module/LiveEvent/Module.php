<?php
namespace LiveEvent;

use Zend\Mvc\MvcEvent;

class Module
{
	public function init($moduleManager)
	{
		$eventManager = $moduleManager->getEventManager();
		$sharedEventManager = $eventManager->getSharedManager();
		$sharedEventManager->attach('LiveEvent', 'dispatch', array($this, 'setLayout'), 1000);
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
					'LiveEvent'		=> __DIR__ . '/src/LiveEvent',
					'LiveEventRest' => __DIR__ . '/src/LiveEventRest'
				)
            ),
        );
    }
    
    public function setLayout(MvcEvent $e)
    {
    	$layout = $e->getViewModel();
    	$layout->setTemplate('live-event/layout');
    	$layout->setVariables(array(
    		'wx_header' => 'wx_header.jpg'
    	));
    }
}