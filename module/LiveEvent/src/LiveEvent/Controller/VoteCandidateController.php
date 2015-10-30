<?php
namespace LiveEvent\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use WxDocument\LiveEvent\VoteCandidate;

require_once (BASE_PATH . "/inc/Qiniu/rs.php");
class VoteCandidateController extends AbstractActionController
{
    public function indexAction()
    {
    	$candidateId = $this->params()-fromRoute('candidateId');
    	
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
    		'candidateDoc' => $candidateDoc,
    		'eventDoc' => $eventDoc
    	);
    }
    
    public function listAction()
    {
    	$eventId = $this->params()-fromQuery('eventId');
    	
    	$sm = $this->getServiceLocator();
    	$dm = $sm->get('DocumentManager');
    	
    	$eventDoc = $dm->getRepository('WxDocument\LiveEvent')->findOneById($eventId);
    	if(is_null($eventDoc)) {
    		throw new PageNotFoundException();
    	}
    	
    	$candidateDocs = $dm->createQueryBuilder('WxDocument\LiveEvent\VoteCandidate')
    		->select('id', 'nickname', 'cover', 'totalTicket')
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
    	$eventId = $this->params()->fromRoute('eventId');
    	
    	$sm = $this->getServiceLocator();
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	
    	$openid = $userAuth->getOpenid();
    	
    	
    	
    }
}