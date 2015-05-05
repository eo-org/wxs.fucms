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
		$promotionType = $data['promotionType'];
		
		$result = array();
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		
		$drawCheck = $sm->get('Promotion\Service\DrawCheck');
		$drawCheck->setParams($data);
		$drawLimitCheckResut = $drawCheck->getDrawLimitCheckResult();
		
		if($drawLimitCheckResut['valid']){
			$probabilityCheckData = array(
				'openId' => $openId,
				'promotionId' => $promotionId,
				'promotionType' => $promotionType,
			);
			$drawCheckresult = $drawCheck->getDrawCheckResult();
			if($drawCheckresult['status']){
				$prizeData = $drawCheckresult['prizeData'];
				$prizeId = $prizeData['_id'];
			
				//减少相应奖品的计数器
				$prizeDoc = $dm->getRepository('Promotion\Document\Prize')->findOneById($prizeId);
				$newRemainderCounter = $prizeData['remainderCounter'] - 1;
				$prizeDoc->setRemainderCounter($newRemainderCounter);
				$prizeData = $prizeDoc->getArrayCopy();
				$prizeId = $prizeData['id'];
				$dm->persist($prizeDoc);
			
				//获取并设置SN号码
				$snDoc = $dm->createQueryBuilder('Promotion\Document\Sn')
							->field('status')->equals('new')
							->field('prizeId')->equals($prizeId)
							->getQuery()->getSingleResult();
				$snData = $snDoc->getArrayCopy();
				$snDoc->setStatus('used');
				$snDoc->setPrizeId($prizeId);
				$dm->persist($snDoc);
				
				$result = array(
					'status' => 'success',
					'msg' => array(
						'snData' => $snData,
						'prizeData' => $prizeData
					),
				);
				$probabilityCheckData['sn'] = $snData['serialCode'];
				$probabilityCheckData['result'] = true;
			}else {
				$result = array(
					'status' => 'error',
					'msg' => $drawCheckresult['msg']
				);
				$probabilityCheckData['result'] = false;
			}
			
			//抽奖记录
			$probabilityCheckDoc = new ProbabilityCheck();
			$probabilityCheckData['created'] = new \DateTime();
			$probabilityCheckDoc->exchangeArray($probabilityCheckData);
			$dm->persist($probabilityCheckDoc);
			$dm->flush();
		}else {
			$result = array(
				'status' => 'error',
				'msg' => $drawLimitCheckResut['msg'],
			);
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