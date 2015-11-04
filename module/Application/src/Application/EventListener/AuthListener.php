<?php
namespace Application\EventListener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

class AuthListener extends AbstractListenerAggregate
{
	public function attach(EventManagerInterface $events)
	{
		$sharedEvents = $events->getSharedManager();
		$this->listeners[] = $sharedEvents->attach(array('User', 'Promotion', 'LiveEvent', 'LiveEventRest', 'FileRest'), 'dispatch', array($this, 'onAuth'), 100);
		$this->listeners[] = $sharedEvents->attach(array('User', 'Promotion', 'LiveEvent'), 'dispatch', array($this, 'onGetJsApiTicket'), 100);
	}
	
	public function onAuth($mvcEvent)
	{
		$sm = $mvcEvent->getApplication()->getServiceManager();
    	
    	$rm = $mvcEvent->getRouteMatch();
    	$router =  $mvcEvent->getRouter();  
    	
    	$sessionUser = $sm->get('User\Service\SessionAuth');
    	
//     	if(true) {
//     		$sessionUser->setOpenid('gavinlocaltestor');
//     	}

    	$dm = $sm->get('DocumentManager');
    	$wxSetting = $dm->createQueryBuilder('WxDocument\Setting')
				    	->select('authorization_info.authorizer_appid')
				    	->getQuery()
				    	->getSingleResult();
    	 
    	$wxSettingArr = $wxSetting->getArrayCopy();
    	$appId = $wxSettingArr['authorization_info']['authorizer_appid'];
    	$jsSignature = $sm->get('Application\Service\JsSignatureService');
    	$jsSignature->setAppId($appId);
    	
    	if(!$sessionUser->isLogin()) {
    		$comAppId = "wx2ce4babba45b702d";
    		
    		$query = $mvcEvent->getRequest()->getQuery();
    		
    		if(isset($query['state'])) {
    			// if the request comes from qq server, use code and componentAccessToken combined to get the user openid
    			// code params will be set if use allow the app to access its info
    			if(isset($query['code'])) {
    				if($query['state'] == 'access-user-info') {
	    				$code = $query['code'];
	    				
	    				$ch = curl_init();
	    				curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/user-info?appId='.$appId.'&code='.$code);
	    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    				$output = curl_exec($ch);
	    				curl_close($ch);
	    				
	    				$userData = json_decode($output, true);
	    				$sessionUser->setOpenid($userData['openid']);
	    				
	    				$sessionUser->setUserData($userData);
    				} else if($query['state'] == 'access-user-base') {
    					$code = $query['code'];
    					
    					$ch = curl_init();
    					curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/user-base?appId='.$appId.'&code='.$code);
    					
    					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    					$output = curl_exec($ch);
    					curl_close($ch);
    					 
    					$userData = json_decode($output, true);
    					$sessionUser->setOpenid($userData['openid']);
    					
    					$sessionUser->setUserData($userData);
    				}
    			} else {
    				throw new \Exception('not allowed');
    			}
    		} else {
    			// redirect to open.weixin.qq.com and ask for a code for the current user
    			$requestUri = $router->getRequestUri();
    			
    			$scope = 'snsapi_userinfo';
    			$location = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".urlencode($requestUri)."&response_type=code&scope=".$scope."&state=access-user-info&component_appid=".$comAppId."#wechat_redirect";
    			
    			header("Location: ".$location);
    			exit(0);
    		}
    	}
	}
	
	public function onGetJsApiTicket($mvcEvent)
	{
		$sm = $mvcEvent->getApplication()->getServiceManager();
		$rm = $mvcEvent->getRouteMatch();
		$router =  $mvcEvent->getRouter();
		$requestUri = $router->getRequestUri();		
		$cmsSiteService = $sm->get('Application\Service\CmsSiteService');
		
		$websiteId = $cmsSiteService->getWebsiteId();
		$websiteId = '547e6e60ce2350a00d000029';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/jsApiTicket/'.$websiteId);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		
		$jsApiTicketObj = json_decode($output);
		$jsApiTicket = $jsApiTicketObj->jsApiTicket;
		$jsSignature = $sm->get('Application\Service\JsSignatureService');
		$jsSignature->setJsApiTicket($jsApiTicket);
		$jsSignature->setUrl($requestUri);
	}
}