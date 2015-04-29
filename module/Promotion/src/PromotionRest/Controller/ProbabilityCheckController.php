<?php

namespace PromotionRest\Controller;


use MongoRegex;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Promotion\Document\ProbabilityCheck;

class ProbabilityCheckController extends AbstractRestfulController
{
	public function getList()
	{
		return new JsonModel(array());
	}
	
	public function get($id)
	{
		return new JsonModel(array());
	}
	
	public function create($data)
	{
		$promotionId = $data['promotionId'];
		$openId = $data['openId'];
		
		$recordData = array(
			'openId' => $openId,
			'promotionId' => $promotionId,
		);
		$result = array();
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		
		$drawCheck = $sm->get('Promotion\Service\DrawCheck');
		$drawCheck->setParams($data);
		$drawLimitCheckResut = $drawCheck->getDrawLimitCheckResult();
		
		if($drawLimitCheckResut['status']){
			$result = array(
				'status' => 'error',
				'msg' => $drawLimitCheckResut['msg']
			);
		}else {
			$drawCheckResut = $drawCheck->getDrawCheckResult();
			if($drawCheckResut['status']){
				$prizeData = $drawCheckResut['prizeData'];
				$prizeId = $prizeData['_id'];
				
				//减少相应奖品的计数器
				$prizeDoc = $dm->getRepository('Promotion\Document\Prize')->findOneById($prizeId);
				$newRemainderCounter = $prizeData['remainderCounter'] - 1;
				$prizeDoc->setRemainderCounter($newRemainderCounter);
				
				//获取并设置SN号码				
				$snDoc = $dm->createQueryBuilder('Promotion\Document\Sn')
							->field('status')->equals('new')
							->field('prizeId')->equals($prizeId)
							->getQuery()->getSingleResult();
				$snData = $snDoc->getArrayCopy();
				$snDoc->setStatus('used');
			}else {
				
			}
			$result = $drawCheckResut;
		}
		
		return new JsonModel($result);
	}
	
	public function update($id, $data)
	{
		return new JsonModel(array());
	}
	
	public function delete($id)
	{
		return new JsonModel(array());
	}
}