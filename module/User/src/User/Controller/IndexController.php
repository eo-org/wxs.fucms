<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$sm = $this->getServiceLocator();
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	
    	$openid = $userAuth->getOpenid();
    	
    	return array(
    		'openid' => $openid
    	);	
    }
}