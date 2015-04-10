<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$userAuth = $this->getServiceLocator()->get('User\Service\SessionAuth');
    	
    	$openId = $userAuth->getOpenId();
    	
    	return array(
    		'openId' => $openId
    	);	
    }
}