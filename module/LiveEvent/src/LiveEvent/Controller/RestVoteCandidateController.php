<?php
namespace LiveEvent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RestVoteCandidateController extends AbstractRestfulController
{
	public function getList()
	{
		$filter = $this->getRequest()->getQuery();
		$eventId = $filter['eventId'];
		$currentPage = $this->params()->fromRoute('page');
		$pageSize = 40;
		$skip = $pageSize * ($currentPage - 1);
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		
		$qb = $dm->createQueryBuilder('WxDocument\LiveEvent\VoteCandidate')
			->field('eventId')->equals($eventId)
    		->field('infoComplete')->equals(true);
		$docs = $qb->limit($pageSize)->skip($skip)->sort('ticketCount', -1)->getQuery()->execute();
		$data = array();
		
		foreach ($docs as $doc){
			$data[] = $doc->getArrayCopy();
		}
		$result['data'] = $data;
		return new JsonModel($result);
	}
	
	public function get($id)
	{
		
	}
	
	public function create($data)
	{
		
	}
	
	public function update($id, $data)
	{
	
	}
	
	public function delete($id)
	{
	
	}
}