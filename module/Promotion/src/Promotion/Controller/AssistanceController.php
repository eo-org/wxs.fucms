<?php
namespace Promotion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use WxDocument\Promotion\AssistanceRecord;

class AssistanceController extends AbstractActionController
{
	public function indexAction()
	{
		$id = $this->params()->fromRoute('id');
		$websiteId = $this->params()->fromRoute('websiteId');
		$fromId = $this->params()->fromQuery('fromId');
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		$userAuth = $sm->get('User\Service\SessionAuth');
		$openId = $userAuth->getOpenId();

// 		$openId = 'localhost';
		$userData = $userAuth->getUserData();
		$jsSignature = $sm->get('Application\Service\JsSignatureService');
		$wxConfigStr = $jsSignature->getJsSdkConfig();
		
		$assistanceDoc = $dm->getRepository('WxDocument\Promotion\Assistance')->findOneById((int)$id);		
		if(empty($assistanceDoc)) {
			return false;
		}
		$promotionData = $assistanceDoc->getArrayCopy();
		$stauts = $assistanceDoc->isActive();
		if($stauts == 'ending') {
			return $this->redirect()->toUrl('/'.$websiteId.'/promotion/assistance/ending/'.$id);
		}
		
		if(empty($fromId)){
			$fromId = $openId;			
		}
		$partakeInfo = array(
			'status' => false,
			'fromId' => $fromId
		);
		$recordDoc = $dm->getRepository('WxDocument\Promotion\AssistanceRecord')->findOneByOpenId($fromId);
		if(empty($recordDoc)) {
			$recordData = array(
				'openId' => $openId,
				'nickname' => $userData['nickname'],
				'headimgurl' => $userData['headimgurl'],
				'value'	=> $promotionData['initialValue']
			);
			$assistanceRecordDoc = new AssistanceRecord();
			$assistanceRecordDoc->exchangeArray($recordData);
			$dm->persist($assistanceRecordDoc);
			$dm->flush();
		}else {
			$recordData = $recordDoc->getArrayCopy();
			if($recordDoc->isAid($openId)){
				$partakeInfo = array(
					'status' => true,
					'value' => $recordData['aidSource'][$openId],
					'fromId' => $fromId
				);
			}
		}
		$postData = array(
			'openId' => $openId,
			'promotionData' => $promotionData
		);
		$postDataStr = json_encode($postData);
		
		$shareData = array(
			'link'=> 'http://wxs.fucmsweb.com/'.$websiteId.'/promotion/assistance/index/'.$id,
		);
		$shareStr = json_encode($shareData);
		return array(
			'promostionUrl' => $shareData['link'],
			'openId' => $openId,
			'wxConfig' => $wxConfigStr,
			'postData' => $postDataStr,
			'recordData' => $recordData,
			'postUrl' => '/wxsrs/'.$websiteId.'/promotion-assistance.json/'.$fromId,
			'promotionData' => $promotionData,
			'partakeInfo'	=> $partakeInfo,
			'shareData' => $shareStr,
			'userData'	=> json_encode($userData)
		);
	}
	
	public function endingAction()
	{
		
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		$id = $this->params()->fromRoute('id');
		$assistanceDoc = $dm->getRepository('WxDocument\Promotion\Assistance')->findOneById((int)$id);
		if(empty($assistanceDoc)){
			return false;
		}
		$promotionData = $assistanceDoc->getArrayCopy();
		return array(
			'endImg' => $promotionData['endImg'],
			'label'	=> $promotionData['endLabel'],
			'endExplain' => $promotionData['endExplain']
		);
	}
}