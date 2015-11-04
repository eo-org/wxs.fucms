<?php
namespace LiveEvent\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use WxDocument\LiveEvent\Applicant;
use Zend\View\Model\Zend\View\Model;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$websiteId = $this->params()->fromRoute('websiteId');
    	$eventId = $this->params()->fromRoute('eventId');
    	
    	$sm = $this->getServiceLocator();
    	$dm = $sm->get('DocumentManager');
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	$openid = $userAuth->getOpenid();
    	
    	$eventDoc = $dm->getRepository('WxDocument\LiveEvent')->findOneById($eventId);
    	
    	if(is_null($eventDoc)) {
    		throw new \Exception('event not found');
    	}
    	
    	$applicantDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\Applicant')
   			->field('openid')->equals($openid)
   			->field('eventId')->equals($eventId)
   			->getQuery()
   			->getSingleResult();
    	if(is_null($applicantDoc)) {
    		$vm = new ViewModel();
    		$vm->setTemplate('live-event/index/apply');
    		$vm->setVariables(array(
    			'websiteId' => $websiteId,
    			'eventId' => $eventId,
    			'eventDoc' => $eventDoc,
    		));
    		return $vm;
    	}
    	
    	$voteActivated = true;
    	if($voteActivated) {
	    	$candidateDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\VoteCandidate')
	   			->field('openid')->equals($openid)
	   			->field('eventId')->equals($eventId)
	   			->getQuery()
	   			->getSingleResult();
	    	if(is_null($candidateDoc)) {
	    		$candidateStatus = 'not-found';
	    		$voteConfig = array(
	    			'candidateStatus' => $candidateStatus,
	    			'candidateDoc' => $candidateDoc
	    		);
	    	} elseif($candidateDoc->getInfoComplete()) {
	    		$candidateStatus = 'complete';
	    		$voteConfig = array(
	    			'candidateStatus' => $candidateStatus,
	    			'candidateId' => $candidateDoc->getId(),
	    			'candidateDoc' => $candidateDoc
	    		);
	    	} else {
	    		$candidateStatus = 'not-complete';
	    		$voteConfig = array(
	    			'candidateStatus' => $candidateStatus,
	    			'candidateId' => $candidateDoc->getId(),
	    			'candidateDoc' => $candidateDoc
	    		);
	    	}
    	}
    	
    	return array(
    		'websiteId' => $websiteId,
    		'eventId' => $eventId,
    		'eventDoc' => $eventDoc,
    		'applicantDoc' => $applicantDoc,
    		'applicantInfo' => $applicantDoc->getInfo(),
    		
    		'voteActivated' => $voteActivated,
    		'voteConfig' => $voteConfig
    	);
    }
    
    public function signUpAction()
    {
    	$eventId = "hsy";
    	
    	$errorMsg = "";
    	$name = "";
    	$sex = "";
    	$idNumber = "";
    	$address = "";
    	
    	$sm = $this->getServiceLocator();
    	$dm = $sm->get('DocumentManager');
    	$userAuth = $sm->get('User\Service\SessionAuth'); 
    	$openid = $userAuth->getOpenid();
    	
    	$userDoc = $dm->getRepository('User\Document\User')->findOneByOpenid($openid);
    	$fcUserId = $userDoc->getFcUserId();
    	if(empty($fcUserId)) {
    		die('请先绑定网站用户');
    	}
    	
    	$applicantDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\Applicant')
    		->field('openid')->equals($openid)
    		->field('eventId')->equals($eventId)
    		->getQuery()
    		
    		->getSingleResult();
    	if($applicantDoc) {
    		$vm = new ViewModel();
    		$vm->setTemplate('live-event/index/success');
    		return $vm;
    	}
    	
    	if($this->getRequest()->isPost()) {
    		$name = $this->params()->fromPost('name');
    		$sex = $this->params()->fromPost('sex');
    		$idNumber = $this->params()->fromPost('idNumber');
    		$address = $this->params()->fromPost('address');
    		if(empty($name) || empty($sex) || empty($idNumber) || empty($address)) {
    			$errorMsg = "请填写所有信息";
    		} else {
    			$dm->clear();
    			$applicantDoc = new Applicant();
    			$applicantDoc->setOpenid($openid);
    			$applicantDoc->setEventId($eventId);
    			$applicantDoc->setInfo(array(
    				'name' => $name,
		    		'sex' => $sex,
		    		'idNumber' => $idNumber,
		    		'address' => $address,
    			));
    			
    			$dm->persist($applicantDoc);
    			$dm->flush();
    			
    			$vm = new ViewModel();
    			$vm->setTemplate('live-event/index/success');
    			return $vm;
    		}
    	}
    	return array(
    		'errorMsg' => $errorMsg,
    		'name' => $name,
    		'sex' => $sex,
    		'idNumber' => $idNumber,
    		'address' => $address,
    	);
    }
    
    public function preEventAction()
    {
    	$websiteId = $this->params()->fromRoute('websiteId');
    	$eventId = 'hust-reunion';
    	 
    	$sm = $this->getServiceLocator();
    	$dm = $sm->get('DocumentManager');
    	
    	$config = $this->getServiceLocator()->get('Config');
    	$bucket = $config['env']['qiniu']['bucket'];
    	$accessKey = $config['env']['qiniu']['keyId'];
    	$secretKey = $config['env']['qiniu']['keySecret'];
    	 
    	Qiniu_SetKeys($accessKey, $secretKey);
    	 
    	$putPolicy = new \Qiniu_RS_PutPolicy($bucket);
    	$putPolicy->insertOnly = 1;
    	$putPolicy->Expires = 10800;
    	$putPolicy->ReturnBody = '{"key":$(key), "mimeType": $(mimeType), "ext": $(ext), "avinfo": $(avinfo)}';
    	$uptoken = $putPolicy->Token(null);
    	  
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	$openid = $userAuth->getOpenid();
		
    	$applicantDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\Applicant')
	    	->select('info')
	    	->field('openid')->equals($openid)
	    	->field('eventId')->equals($eventId)
	    	->getQuery()
	    	->getSingleResult();
    	if(!is_null($applicantDoc)) {
    		$applicantId = $applicantDoc->getId();
    		$applicantInfo = $applicantDoc->getInfo();
    	} else {
    		$applicantId = '';
    		$applicantInfo = array(
    			'name' => '',
    			'mobile' => '',
    			'city' => '',
    			'work' => ''
    		);
    	}
    	
    	$userData = array();
    	 
    	return array(
    		'websiteId'		=> $websiteId,
    		'uptoken'		=> $uptoken,
    		'openid'		=> $openid,
    		'eventId'		=> $eventId,
    		'applicantId'	=> $applicantId,
    		//'userData'	=> json_encode($userData),
    		'applicantInfo' => $applicantInfo,
    	
    	);
    }
    
    public function postEventAction()
    {
    	
    }
    
    public function viewImgAction()
    {
    	$websiteId = $this->params()->fromRoute('websiteId');
    	$eventId = 'hust-reunion';
    	$sm = $this->getServiceLocator();
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	$openid = $userAuth->getOpenid();
    	
    	$dm = $sm->get('DocumentManager');
    	
    	$uploadedImgs = $dm->createQueryBuilder('WxDocument\File')
    		->field('openid')->equals($openid)
    		->field('resourceId')->equals($eventId)
    		->getQuery()
    		->execute();
    	
    	return array(
    		'websiteId' => $websiteId,
    		'uploadedImgs' => $uploadedImgs
    	);
    }
    
    public function reviewAction()
    {
    	
    }
}