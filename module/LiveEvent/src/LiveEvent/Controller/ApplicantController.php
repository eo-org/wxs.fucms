<?php
namespace LiveEvent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ApplicantController extends AbstractActionController
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
    		$applicantDoc = new \WxDocument\LiveEvent\Applicant();
    	}
    	
    	if($this->getRequest()->isPost()) {
    		$data = $this->getRequest()->getPost();
    		
    		$applicantDoc->exchangeArray($data);
    		$applicantDoc->setEventId($eventId);
    		$applicantDoc->setOpenid($openid);
    		
    		$dm->persist($applicantDoc);
    		$dm->flush();
    		
    		if(true) {//nothing wrong, let's presume nothing is wrong at the moment
    			$vm = new ViewModel();
    			if(true) {//open event
    				$vm->setTemplate('live-event/applicant/success');
    			} else {
    				$vm->setTemplate('live-event/applicant/waiting-approve');
    			}
    			
    			$vm->setVariables(array(
    				'websiteId' => $websiteId,
    				'eventId' => $eventId,
    				'eventDoc' => $eventDoc,
    				'applicantDoc' => $applicantDoc
    			));
    			
    			return $vm;
    		}
    		
    	}
    	
    	return array(
    		'websiteId' => $websiteId,
    		'eventId' => $eventId,
    		'eventDoc' => $eventDoc,
    		'applicantDoc' => $applicantDoc
    	);
    }
}