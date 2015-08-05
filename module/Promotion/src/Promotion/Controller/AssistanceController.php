<?php
namespace Promotion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use WxDocument\Promotion\Assistance;
// use Cms\SiteConfig;

class AssistanceController extends AbstractActionController
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
		
		/***get authorizer_access_koken**/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://wx.fucmsweb.com/api/authorizerAccessToken/'.$websiteId);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		$accessTokenResult = json_decode($output);
		$authorizerAccessToken = $accessTokenResult->authorizerAccessToken;
		
		$getUserInfoUrl = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$authorizerAccessToken.'&openid='.$openId.'&lang=zh_CN';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $getUserInfoUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		$userData = json_decode($output, true);
		
		print_r($userData);
		die();
		//获取活动数据，检测活动有没有过期	
		$dm = $sm->get('DocumentManager');
		$assistanceDoc = $dm->getRepository('WxDocument\Promotion\Assistance')->findOneById((int)$id);
		
		if(empty($assistanceDoc)) {
			return false;
		}
		$stauts = $assistanceDoc->isActive();		
		if($stauts == 'ending') {
			return $this->redirect()->toUrl('/'.$websiteId.'/promotion/assistance/ending/'.$id);
		}
		$promotionData = $assistanceDoc->getArrayCopy();
		$postData = array(
			'openId' => $openId,
			'promotionType' => 'assistance',
			'promotionId' => $id,
		);
		$postDataStr = json_encode($postData);
		
		$openId = 'aa';
		return array(
			'openId' => $openId,
// 			'wxConfig' => $wxConfigStr,
			'postData' => $postDataStr,
			'postUrl' => '/wxsrs/'.$websiteId.'/promotion-probability-check-assistance.json',
			'promotionData' => $promotionData,
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