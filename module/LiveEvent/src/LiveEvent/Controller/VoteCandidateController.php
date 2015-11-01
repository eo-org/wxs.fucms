<?php
namespace LiveEvent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

require_once (BASE_PATH . "/inc/Qiniu/rs.php");
class VoteCandidateController extends AbstractActionController
{
    public function indexAction()
    {
    	$websiteId = $this->params()->fromRoute('websiteId');
    	$eventId = $this->params()->fromRoute('eventId');
    	$candidateId = $this->params()->fromRoute('candidateId');
    	
    	$sm = $this->getServiceLocator();
    	$dm = $sm->get('DocumentManager');
    	 
    	$candidateDoc = $dm->getRepository('WxDocument\LiveEvent\VoteCandidate')->findOneById($candidateId);
    	if(is_null($candidateDoc)) {
    		throw new PageNotFoundException();
    	}
    	
    	$eventId = $candidateDoc->getEventId();
    	$eventDoc = $dm->getRepository('WxDocument\LiveEvent')->findOneById($eventId);
    	if(is_null($eventDoc)) {
    		throw new PageNotFoundException();
    	}
    	
    	return array(
    		'websiteId' => $websiteId,
    		'eventId' => $eventId,
    		'candidateDoc' => $candidateDoc,
    		'eventDoc' => $eventDoc
    	);
    }
    
    public function listAction()
    {
    	$eventId = $this->params()->fromRoute('eventId');
    	
    	$sm = $this->getServiceLocator();
    	$dm = $sm->get('DocumentManager');
    	
    	$eventDoc = $dm->getRepository('WxDocument\LiveEvent')->findOneById($eventId);
    	if(is_null($eventDoc)) {
    		throw new PageNotFoundException();
    	}
    	
    	$candidateDocs = $dm->createQueryBuilder('WxDocument\LiveEvent\VoteCandidate')
    		->select('id', 'nickname', 'cover', 'ticketCount')
    		->field('eventId')->equals($eventId)
    		->getQuery()
    		->execute();
    	
    	return array(
    		'eventDoc'	=> $eventDoc,
    		'candidateDocs' => $candidateDocs
    	);
    }
    
    public function editAction()
    {
    	$websiteId = $this->params()->fromRoute('websiteId');
    	$eventId = $this->params()->fromRoute('eventId');
    	
    	$sm = $this->getServiceLocator();
    	$dm = $sm->get('DocumentManager');
    	
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	$openid = $userAuth->getOpenid();
    	
    	$applicantDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\Applicant')
    		->field('openid')->equals($openid)
    		->field('eventId')->equals($eventId)
    		->getQuery()
    		->getSingleResult();
    	if(is_null($applicantDoc)) {
    		throw new \Exception('applicante document not found!');
    	}
    	
    	$candidateDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\VoteCandidate')
    		->field('openid')->equals($openid)
    		->field('eventId')->equals($eventId)
    		->getQuery()
    		->getSingleResult();
    	if(is_null($candidateDoc)) {
    		$candidateDoc = new \WxDocument\LiveEvent\VoteCandidate();
    		$candidateDoc->setOpenid($openid);
    		$candidateDoc->setEventId($eventId);
    		$dm->persist($candidateDoc);
    		$dm->flush();
    	}
    	
    	if($this->getRequest()->isPost()) {
    		$data = $this->getRequest()->getPost();
    		
    		$candidateDoc->exchangeArray($data);
    		$dm->persist($candidateDoc);
    		$dm->flush();
    		
    		return $this->redirect()->toRoute('wxs/wildcard', array(
    			'controller' => 'le-index',
    			'action' => 'index',
    			'eventId' => $eventId
    		), true);
    	}
    	
    	
    	$config = $this->getServiceLocator()->get('Config');
    	$bucket = $config['env']['qiniu']['bucket'];
    	$accessKey = $config['env']['qiniu']['keyId'];
    	$secretKey = $config['env']['qiniu']['keySecret'];
    	
    	Qiniu_SetKeys($accessKey, $secretKey);
    	
    	$putPolicy = new \Qiniu_RS_PutPolicy($bucket);
    	$putPolicy->insertOnly = 1;
    	$putPolicy->Expires = 10800;
    	$putPolicy->ReturnBody = '{"key":$(key), "mimeType": $(mimeType), "ext": $(ext)}';
    	$uptoken = $putPolicy->Token(null);
    	
    	return array(
    		'websiteId'		=> $websiteId,
    		'uptoken'		=> $uptoken,
    		'candidateDoc'	=> $candidateDoc,
    		'candidateId'	=> $candidateDoc->getId()
    	);
    }
}