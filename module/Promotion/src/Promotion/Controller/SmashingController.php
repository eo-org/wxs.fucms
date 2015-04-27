<?php
namespace Promotion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class SmashingController extends AbstractActionController
{
	public function indexAction()
	{
		$id = $this->params()->fromRoute('id');
		$sm = $this->getServiceLocator();
// 		$userAuth = $sm->get('User\Service\SessionAuth');
// 		$openId = $userAuth->getOpenId();
// 		$jsSignature = $sm->get('Application\Service\JsSignatureService');
// 		$wxConfigStr = $jsSignature->getJsSdkConfig();
		$demo = rand();
		echo $demo;
		die('ok');
		
		
		//获取活动数据，检测活动有没有过期，以及中奖的数目
		
		
		$postData = array(
			'openId' => $openId,
			'promotion' => 'smashing',
			'promotionId' => $id,
		);
		$postDataStr = json_encode($postData);
		return array(
			'openId' => $openId,
			'wxConfig' => $wxConfigStr,
			'postData' => $postDataStr,
		);
	}
	
	public function resultAction()
	{
		$sm = $this->getServiceLocator();
		
		$userAuth = $sm->get('User\Service\SessionAuth');
			
		$openId = $userAuth->getOpenId();
		
// 		$dm = $sm->get('DocumentManager');
		
		
		
// 		$resultDoc = new \WxDocument\PromotionResult();
		
// 		$resultDoc->exchangeArray(array(
// 			'openId' => $openId,
// 			'result' => ''
// 		));
		
// 		$dm->persist($resultDoc);
		
// 		$dm->flush();
		
		return new JsonModel(
			array(
				'result' => 'win'
			)
		);
	}
}