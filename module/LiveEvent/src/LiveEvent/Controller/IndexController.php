<?php
namespace LiveEvent\Controller;

use Zend\Mvc\Controller\AbstractActionController;

require_once (BASE_PATH . "/inc/Qiniu/rs.php");
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	
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