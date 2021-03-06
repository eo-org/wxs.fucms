<?php
namespace LiveEvent\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$sm = $this->getServiceLocator();
    	
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	$openid = $userAuth->getOpenid();
    	
    	$userData = $userAuth->getUserData();
    	$jsSignature = $sm->get('Application\Service\JsSignatureService');
    	$wxConfigStr = $jsSignature->getJsSdkConfig();
    	
    	return array(
    		'openid' => $openid,
    		'wxConfig' => $wxConfigStr,
    		'userData'	=> json_encode($userData)
    	);
    }
    
    public function signUpAction()
    {
    	
    }
    
    public function preEventAction()
    {
    		
    }
    
    public function postEventAction()
    {
    	
    }
    
    public function reviewAction()
    {
    	
    }
}