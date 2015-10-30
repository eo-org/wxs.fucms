<?php
namespace LiveEventRest\Controller;

use Cms\Exception\PageNotFoundException, Cms\Exception\DocumentNotFoundException;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\Zend\View\Model;
use Zend\Config\Reader\Json;

class VoteTicketController extends AbstractRestfulController
{
	public function getList()
	{
		//
		
		return new JsonModel();
	}
	
	public function get($id)
	{
		return new JsonModel();
	}
	
	public function create($data)
	{
		$eventId = $data['eventId'];
		
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		
		$eventDoc = $dm->getRepository('WxDocument\LiveEvent')->findOneById($eventId);
		if(is_null($eventDoc)) {
			throw new PageNotFoundException();
		}
		
		$user = $sm->get('User\Service\SessionAuth');
		$openid = $user->getOpenid();
		
		if(false) {
			//the permission is required before an applicant can create a candidate for event vote campaign;
			$applicantDoc = $dm->getRepository('WxDocument\LiveEvent\Applicant')->findOneByOpenid($openid);
		
		}
		
		$candiateDoc = $dm->getRepository('WxDocument\LiveEvent\VoteCandidate')->findOneByOpenid($openid);
		if(!is_null($candiateDoc)) {
			$response = $this->getResponse();
			$response->setStatusCode(401);
			return new JsonModel(array(
				'errorMsg' => '只能报名一次！'
			));
		}
		
		$candiateDoc = new \WxDocument\LiveEvent\VoteCandidate();
		$candiateDoc->setEventId($eventId);
		$candiateDoc->setOpenid($openid);
		
		$dm->persist($candiateDoc);
		$dm->flush();
		
		return new JsonModel();
	}
	
	public function update($id, $data)
	{
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		
		$user = $sm->get('User\Service\SessionAuth');
		$openid = $user->getOpenid();
		
		$candiateDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\VoteCandidate')
			->field('id')->equals($id)
			->field('openid')->equals($openid)
			->getQuery()
			->getSingleResult();
		if(is_null($candiateDoc)) {
			throw new DocumentNotFoundException();
		}
		
		$candiateDoc->exchangeArray($data);
		
		$dm->persist($candiateDoc);
		$dm->flush();
		
		return new JsonModel();
	}
	
	public function delete($id)
	{
				
	}
}