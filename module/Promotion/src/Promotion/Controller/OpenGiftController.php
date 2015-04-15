<?php
namespace Promotion\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class OpenGiftController extends AbstractActionController
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