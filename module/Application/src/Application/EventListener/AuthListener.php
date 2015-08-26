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
		$this->listeners[] = $sharedEvents->attach(array('User', 'Promotion', 'LiveEvent', 'LiveEventRest', 'FileRest'), 'dispatch', array($this, 'onAuth'), 100);
		$this->listeners[] = $sharedEvents->attach(array('User', 'Promotion'), 'dispatch', array($this, 'onGetJsApiTicket'), 100);
	}
	
	public function onAuth($mvcEvent)
	{
		$sm = $mvcEvent->getApplication()->getServiceManager();
    	
    	$rm = $mvcEvent->getRouteMatch();
    	$router =  $mvcEvent->getRouter();  
    	
    	$sessionUser = $sm->get('User\Service\SessionAuth');
    	
//     	$config = $sm->get('Config');
//     	if($config['env']['usage']['server'] == 'development') {
//     		$sessionUser->setOpenId('localtestor');
//     	}
    	
    	if(!$sessionUser->isLogin()) {
    		
    		$dm = $sm->get('DocumentManager');
    		$wxSetting = $dm->createQueryBuilder('WxDocument\Setting')
	    		->select('authorization_info.authorizer_appid')
	    		->getQuery()
	    		->getSingleResult();
    		 
    		$wxSettingArr = $wxSetting->getArrayCopy();
    		$appId = $wxSettingArr['authorization_info']['authorizer_appid'];
    		$comAppId = "wx2ce4babba45b702d";
    		
    		
    		
    		
    		$query = $mvcEvent->getRequest()->getQuery();
    		
    		if(isset($query['state'])) {
    			// if the request comes from qq server, use code and componentAccessToken combined to get the user openId
    			if(isset($query['code'])) {
    				//$authState = $query['state'];
    				$code = $query['code'];
    				
    				$postVar = array(
    					'appId' => $appId,
    					'code' => $code
    				);
    				$ch = curl_init();
    				curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/user-info?appId='.$appId.'&code='.$code);
    				//curl_setopt($ch, CURLOPT_POST, 1 );
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    				curl_setopt($ch, CURLOPT_POSTFIELDS, $postVar);
    				$output = curl_exec($ch);
    				curl_close($ch);
    				
    				
    				
//     				print_r($output);
//     				$tokenObj = json_decode($output);
    				
//     				print_r($tokenObj);
    				
//     				die();
    				
    				
//     				$ch = curl_init();
//     				curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/component-access-token');
//     				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     				$output = curl_exec($ch);
//     				curl_close($ch);
    				 
//     				$tokenObj = json_decode($output);
    				 
//     				$componentAccessToken = $tokenObj->componentAccessToken;
    				 
    				 
//     				$url = "https://api.weixin.qq.com/sns/oauth2/component/access_token      ?appid=wx536a9272e58807e7&code=".$code."&grant_type=authorization_code&component_appid=wx2ce4babba45b702d&component_access_token=".$componentAccessToken;
    				
//     				$ch = curl_init();
//     				curl_setopt($ch, CURLOPT_URL, $url);
//     				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     				$output = curl_exec($ch);
//     				curl_close($ch);
    				
    				 
//     				$openIdObj = json_decode($output);
//     				$openId = $openIdObj->openid;
//     				$accessToken = $openIdObj->access_token;
    				
//     				$getUserInfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$accessToken.'&openid='.$openId.'&lang=zh_CN';
//     				$ch = curl_init();
//     				curl_setopt($ch, CURLOPT_URL, $getUserInfoUrl);
//     				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     				$output = curl_exec($ch);
//     				curl_close($ch);
    				
    				$userData = json_decode($output, true);
    				$sessionUser->setOpenId($userData['openId']);
    				if($userData['scope'] == 'snsapi_userinfo') {
    					$sessionUser->setUserData($userData);
    				}
    			} else {
    				throw new \Exception('not allowed');
    			}
    		} else {
    			// redirect to open.weixin.qq.com and ask for a code for the current user
    			
    			$requestUri = $router->getRequestUri();
    			
    			$scope = 'snsapi_base';
    			$location = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".urlencode($requestUri)."&response_type=code&scope=".$scope."&state=access-openid&component_appid=".$comAppId."#wechat_redirect";
    			
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