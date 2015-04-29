<?php
namespace Promotion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Promotion\Document\Smashing;

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
		
		$postDataStr = null;
		
		//获取活动数据，检测活动有没有过期	
		$dm = $sm->get('DocumentManager');
		$smashingDoc = $dm->getRepository('Promotion\Document\Smashing')->findOneById($id);
		$stauts = $smashingDoc->isActive();
		$smashingData = $smashingDoc->getArrayCopy();		
		if($stauts == 'active') {
			$postData = array(
				'openId' => $openId,
				'promotion' => 'smashing',
				'promotionId' => $id,
			);
			$postDataStr = json_encode($postData);
		}else if($stauts == 'inactive' ) {
			die('inactive');
		}else {
			die('ending');
		}
		
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