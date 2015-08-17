<?php
namespace LiveEvent;

use Zend\Mvc\MvcEvent;

class Module
{
	public function init($moduleManager)
	{
		
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
}