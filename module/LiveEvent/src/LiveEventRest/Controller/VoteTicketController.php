<?php
namespace LiveEventRest\Controller;

use Cms\Exception\PageNotFoundException;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\Zend\View\Model;

class VoteTicketController extends AbstractRestfulController
{
	public function getList()
	{
		
	}
	
	public function get($id)
	{
		
	}
	
	public function create($data)
	{
		$eventId = $data['eventId'];
		$candidateId = $data['candidateId'];
		
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		
		$eventDoc = $dm->getRepository('WxDocument\LiveEvent')->findOneById($eventId);
		if(is_null($eventDoc)) {
			throw new PageNotFoundException();
		}
		$candiateDoc = $dm->getRepository('WxDocument\LiveEvent\VoteCandidate')->findOneById($candidateId);
		if(is_null($candiateDoc)) {
			throw new PageNotFoundException();
		}
		
		$user = $sm->get('User\Service\SessionAuth');
		$openid = $user->getOpenid();
		$key = 'wxlev:'.$eventId.':'.$openid;
		
		$redisClient = $sm->get('RedisClient');
		$ticketCount = $redisClient->lSize($key);
		
		if($ticketCount >= 3) {
			$response = $this->getResponse();
			$response->setStatusCode(220);
			return new JsonModel(array(
				'errorMsg' => '每天仅有三次投票机会，请明天再来吧！'
			));
		} else if($ticketCount == 0) {
			$redisClient->rpush($key, $candidateId);
			$midnight = mktime(23, 59, 59, date('n'), date('j'), date('Y'));
			$redisClient->expireAt($key, $midnight);
		} else {
			if(true) {//one candidate gets one ticket at most
				$range = $redisClient->lRange($key, 0, -1);
				if(in_array($candidateId, $range)) {
					$response = $this->getResponse();
					$response->setStatusCode(220);
					return new JsonModel(array(
						'errorMsg' => '每天仅有三次投票机会，请明天再来吧！'
					));
				}
			}
			$redisClient->rpush($key, 'voteCandidateId');
		}
		
		$candiateDoc = $dm->createQueryBuilder('WxDocument\LiveEvent\VoteCandidate')
			->findAndUpdate()
			->field('id')->equals($candidateId)
			->field('ticketCount')->inc(1)
			->getQuery()
			->execute();
		
		return new JsonModel();
	}
	
	public function update($id, $data)
	{
		
	}
	
	public function delete($id)
	{
				
	}
}