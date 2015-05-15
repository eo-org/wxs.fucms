<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$sm = $this->getServiceLocator();
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	
    	$openId = $userAuth->getOpenId();
    	
    	return array(
    		'openId' => $openId
    	);	
    }
}