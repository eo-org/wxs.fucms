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
    	$router =  $e->getRouter();  
    	
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	
    	if(!$userAuth->isLogin()) {
    		
    		$query = $e->getRequest()->getQuery();
    		
    		if(isset($query['state']) && $query['state'] == 'access-openid') {
    			if(isset($query['code'])) {
    				
    				$requestUri = $router->getRequestUri();
    				
    				$code = $query['code'];
    				
    				$ch = curl_init();
    				curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/component-access-token');
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    				$output = curl_exec($ch);
    				curl_close($ch);
    				 
    				$tokenObj = json_decode($output);
    				 
    				$componentAccessToken = $tokenObj->componentAccessToken;
    				 
    				 
    				$url = "https://api.weixin.qq.com/sns/oauth2/component/access_token?appid=wx536a9272e58807e7&code=".$code."&grant_type=authorization_code&component_appid=wx2ce4babba45b702d&component_access_token=".$componentAccessToken;
    				 
    				$ch = curl_init();
    				curl_setopt($ch, CURLOPT_URL, $url);
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    				$output = curl_exec($ch);
    				curl_close($ch);
    				
    				 
    				$openIdObj = json_decode($output);
    				$openId = $openIdObj->openid;
    				 
    				$userAuth->setOpenId($openId);
    			} else {
    				throw new \Exception('not allowed');
    			}
    		} else {
    			header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx536a9272e58807e7&redirect_uri=http%3A%2F%2Fwxs.fucmsweb.com%2Fuser&response_type=code&scope=snsapi_base&state=access-openid&component_appid=wx2ce4babba45b702d#wechat_redirect");
    			exit(0);
    		}
    	}
    }
}