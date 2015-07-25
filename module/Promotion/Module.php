<?php
namespace Promotion;

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
					__NAMESPACE__	=> __DIR__ . '/src/' . __NAMESPACE__,
					'PromotionRest' => __DIR__ . '/src/PromotionRest',
					'Promotion' => __DIR__ . '/src/Promotion',
					'WxDocument'	=> BASE_PATH . '/inc/WxDocument'
				)
            ),
        );
    }
}