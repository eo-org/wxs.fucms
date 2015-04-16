<?php
namespace Promotion\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class SmashingController extends AbstractActionController
{
	public function indexAction()
	{
		$userAuth = $this->getServiceLocator()->get('User\Service\SessionAuth');
		 
		$openId = $userAuth->getOpenId();
		
		return array(
			'openId' => $openId
		);
	}
	
	public function resultAction()
	{
		$sm = $this->getServiceLocator();
		
		$userAuth = $sm->get('User\Service\SessionAuth');
			
		$openId = $userAuth->getOpenId();
		
		$dm = $sm->get('DocumentManager');
		
		
		
		$resultDoc = new \WxDocument\PromotionResult();
		
		$resultDoc->exchangeArray(array(
			'openId' => $openId,
			'result' => ''
		));
		
		$dm->persist($resultDoc);
		
		$dm->flush();
		
		return array(
			'result' => 'win'
		);
	}
}