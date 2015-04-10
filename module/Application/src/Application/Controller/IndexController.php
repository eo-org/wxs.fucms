<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Qiniu\json_decode;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	
    }
    
    public function getUserCodeAction()
    {
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	
    	if($userAuth->isLogin()) {
    		
    	}
    	
    	$code = $this->params()->fromQuery('code');
    	
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/component-access-token');
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$output = curl_exec($ch);
    	curl_close($ch);
    	
    	$tokenObj = json_decode($output);
    	
    	$componentAccessToken = $tokenObj['componentAccessToken'];
    	
    	
    	$url = "https://api.weixin.qq.com/sns/oauth2/component/access_token?appid=wx536a9272e58807e7&code=".$code."&grant_type=authorization_code&component_appid=wx2ce4babba45b702d&component_access_token=".$componentAccessToken;
    	
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// //    	curl_setopt($ch, CURLOPT_POST, 1);
//     	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    	$output = curl_exec($ch);
    	curl_close($ch);
    	
    	print_r($output);
    	
    }
}