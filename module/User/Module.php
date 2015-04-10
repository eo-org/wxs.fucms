<?php
namespace User;

use Zend\Mvc\MvcEvent;

class Module
{
	public function init($moduleManager)
	{
		$eventManager = $moduleManager->getEventManager();
		$sharedEventManager = $eventManager->getSharedManager();
		
		$sharedEventManager->attach(__NAMESPACE__, 'dispatch', array($this, 'userAuth'), 100);
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
    	$sm = $e->getApplication()->getServiceManager();
    	
    	$rm = $e->getRouteMatch();
    	$matchedRouteName = $rm->getMatchedRouteName();
    	
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	
    	if(!$userAuth->isLogin()) {
    		header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx536a9272e58807e7&redirect_uri=http%3A%2F%2Fwxs.fucmsweb.com%2Fget-user-code&response_type=code&scope=snsapi_base&state=gavin&component_appid=wx2ce4babba45b702d#wechat_redirect");
    		exit(0);
    	}
    }
}