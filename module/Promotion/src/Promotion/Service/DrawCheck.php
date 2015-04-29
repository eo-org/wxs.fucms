<?php
namespace Promotion\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DrawCheck implements ServiceLocatorAwareInterface
{
	protected $sm;
	protected $params;
	protected $promotionData;
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->sm = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->sm;
	}
	
	public function setParams($params)
	{
		$this->params = $params;
	}
	
	public function getDrawLimitCheckResult()
	{
		$dm = $this->sm->get('DocumentManager');
		$params = $this->params;
		$promotionId = $params['promotionId'];
		$openId = $params['openId'];
		$promotionData = $smashingDoc->getArrayCopy();
		
		$this->promotionData = $promotionData;
		$drawLimit = $promotionData['drawLimit'];
		$drawLimitDaily = $promotionData['drawLimitDaily'];
		
									->field('openId')->equals($openId)
									->field('promotionId')->equals($promotionId)
									->hydrate(false)
									->getQuery()->execute();
		
		$drawNumber = intval($ProbabilityCheckDocs->count());
		if($drawNumber < $drawLimit){
			if($drawNumber > 0){
				$drawNumberDaily = 0;
				$currentTime = new \DateTime();
				$ProbabilityCheckDatas = $this->formatData($ProbabilityCheckDocs);
				foreach ($ProbabilityCheckDatas as $ItemData) {
					
				}
			}else {
				$result = array(
					'status' => false
				);
			}
		}else {
			$result = array(
				'status' => true,
				'msg' => '您的抽奖次数已使用完，谢谢您的参与!'
			);
		}		
		return $result;
	}
	
	public function getDrawCheckResult()
	{
		$promotionData = $this->promotionData;
		$promotionId = $promotionData['id'];
		$odds = $promotionData['odds'];
		$prizes = $promotionData['prizes'];
		$number = rand(0, 100);
		if($number < $odds) {
			$dm = $this->sm->get('DocumentManager');
									->field('remainderCounter')->gt(0)
									->field('promotionId')->equals($promotionId)
									->hydrate(false)
									->getQuery()->execute();
			$prizeTotality = 0;
			foreach ($prizeDocs as $prizeData) {
				$prizeTotality = $prizeTotality + $prizeData['quantity'];
			}
			$drawNumber = rand(1, $prizeTotality);
			foreach ($prizeDocs as $prizeData) {
				if($drawNumber <= $prizeData['quantity']){
					$drawResult = $prizeData;
					break;
				}else {
					$drawNumber = $drawNumber - $prizeData['quantity'];
				}
			}			
			$result = array(
				'status' => true,
				'prizeData' => $drawResult,
			);
		}else {
			$result = array(
				'status' => false,
				'msg' => '很遗憾，你没有中奖',
			);
		}		
		return $result;
	}
}
