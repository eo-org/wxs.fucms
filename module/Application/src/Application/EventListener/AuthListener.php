<?php
namespace Application\EventListener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Cms\Document\SubsiteInterface;

class AuthListener extends AbstractListenerAggregate
{
	public function attach(EventManagerInterface $events)
	{
		$sharedEvents = $events->getSharedManager();
		$this->listeners[] = $sharedEvents->attach(array('User'), 'dispatch', array($this, 'onAuth'), 100);
	}
	
	public function onAuth($mvcEvent)
	{
		$sm = $mvcEvent->getApplication()->getServiceManager();
    	
    	$rm = $mvcEvent->getRouteMatch();
    	$router =  $mvcEvent->getRouter();  
    	
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	
    	if(!$userAuth->isLogin()) {
    		
    		$query = $mvcEvent->getRequest()->getQuery();
    		
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
    			$requestUri = $router->getRequestUri();
    			header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx536a9272e58807e7&redirect_uri=".urlencode($requestUri)."&response_type=code&scope=snsapi_base&state=access-openid&component_appid=wx2ce4babba45b702d#wechat_redirect");
    			exit(0);
    		}
    	}
	}
}