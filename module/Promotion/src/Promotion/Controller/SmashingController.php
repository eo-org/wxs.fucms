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
		$websiteId = $this->params()->fromRoute('websiteId');
		$sm = $this->getServiceLocator();
		$userAuth = $sm->get('User\Service\SessionAuth');
		$openId = $userAuth->getOpenId();
		$jsSignature = $sm->get('Application\Service\JsSignatureService');
		$wxConfigStr = $jsSignature->getJsSdkConfig();
		
		//获取活动数据，检测活动有没有过期	
		$dm = $sm->get('DocumentManager');
		$smashingDoc = $dm->getRepository('Promotion\Document\Smashing')->findOneById((int)$id);
		
		if(empty($smashingDoc)) {
			return false;
		}
		$stauts = $smashingDoc->isActive();
		$smashingData = $smashingDoc->getArrayCopy();
// 		$openId = 'aa';
		if($stauts == 'active') {
			$postData = array(
				'openId' => $openId,
				'promotionType' => 'smashing',
				'promotionId' => $id,
			);
			$postDataStr = json_encode($postData);
		}else if($stauts == 'inactive' ) {
			return $this->redirect()->toUrl('/'.$websiteId.'/promotion/smashing/ending/'.$id);
		}else {
			return $this->redirect()->toUrl('/'.$websiteId.'/promotion/smashing/ending/'.$id);
		}
		
		$postDataStr = null;
		
		$postData = array(
			'openId' => $openId,
			'promotionType' => 'smashing',
			'promotionId' => $id,
		);
		$postDataStr = json_encode($postData);
		
		return array(
			'openId' => $openId,
			'wxConfig' => $wxConfigStr,
			'postData' => $postDataStr,
			'postUrl' => '/wxsrs/'.$websiteId.'/promotion-probability-check.json',
			'snInfoUrl' => '/'.$websiteId.'/promotion/sn-info/index',
			'smashingData' => $smashingData,
		);
	}
	
	public function inactiveAction()
	{
		
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		$id = $this->params()->fromRoute('id');
		$smashingDoc = $dm->getRepository('Promotion\Document\Smashing')->findOneById((int)$id);
		if(empty($smashingDoc)){
			return false;
		}
		$smashingData = $smashingDoc->getArrayCopy();
		
		return array(
			'imgUrl' => $smashingData['inactiveImg']
		);
	}
	
	public function endingAction()
	{
		
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		$id = $this->params()->fromRoute('id');
		$smashingDoc = $dm->getRepository('Promotion\Document\Smashing')->findOneById((int)$id);
		if(empty($smashingDoc)){
			return false;
		}
		$smashingData = $smashingDoc->getArrayCopy();
		return array(
			'endingViewImg' => $smashingData['endingViewImg']
		);
	}
}