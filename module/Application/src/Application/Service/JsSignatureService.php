<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class JsSignatureService implements ServiceLocatorAwareInterface
{
	protected $sm;
	
	protected $jsApiTicket;
	protected $url;
	protected $appId;
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->sm = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->sm;
	}
	
    public function setJsApiTicket($ticket)
    {
    	$this->jsApiTicket = $ticket;
    }
    
    public function setAppId($appId)
    {
    	$this->appId = $appId;
    }
    
    public function setUrl($url)
    {
    	$this->url = $url;
    }
    
    public function getJsSdkConfig()
    {
    	$chars = array(0,1,2,3,4,5,6,7,8,9,'q','a','z','w','s','x','e','d','c','r','f','v','t','g','b','y','h','n','u','j','m','i','k','o','l','p');
    	$max = count($chars) - 1;
    	$nonceStr = '';
    	for($j = 0; $j < 12; $j++){
    		$nonceStr .= $chars[rand(0, $max)];
    	}    	
    	$timestamp = time();
    	$str = 'jsapi_ticket='.$this->jsApiTicket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$this->url;
    	$signature = sha1($str);
    	$appId = $this->appId;
    	$jsApiList = "['checkJsApi',
				        'onMenuShareTimeline',
				        'onMenuShareAppMessage',
				        'onMenuShareQQ',
				        'onMenuShareWeibo',
				        'hideMenuItems',
				        'showMenuItems',
				        'hideAllNonBaseMenuItem',
				        'showAllNonBaseMenuItem',
				        'translateVoice',
				        'startRecord',
				        'stopRecord',
				        'onRecordEnd',
				        'playVoice',
				        'pauseVoice',
				        'stopVoice',
				        'uploadVoice',
				        'downloadVoice',
				        'chooseImage',
				        'previewImage',
				        'uploadImage',
				        'downloadImage',
				        'getNetworkType',
				        'openLocation',
				        'getLocation',
				        'hideOptionMenu',
				        'showOptionMenu',
				        'closeWindow',
				        'scanQRCode',
				        'chooseWXPay',
				        'openProductSpecificView',
				        'addCard',
				        'chooseCard',
				        'openCard']";
	    $wxconfigStr = '{debug: true, appId: "'.$appId.'", timestamp: "'.$timestamp.'", nonceStr: "'.$nonceStr.'", signature: "'.$signature.'",jsApiList: '.$jsApiList.' }';
    	
    	return $wxconfigStr;
    }
}
