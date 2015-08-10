<?php

namespace PromotionRest\Controller;


use MongoRegex;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class AssistanceController extends AbstractRestfulController
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
		
		return new JsonModel(array());
	}
	
	public function update($id, $data)
	{
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		
		$recordDoc = $dm->getRepository('WxDocument\Promotion\AssistanceRecord')->findOneByOpenId($id);
		$recordData = $recordDoc->getArrayCopy();
		
		$openId = $data['openId'];
		$promotionData = $data['promotionData'];		
		$number = rand($promotionData['minValue'], $promotionData['maxValue']);
		
		$recordData['value'] = $recordData['value'] + $number;
		
		$aidSource = $recordData['aidSource'] || array();
		$aidSource[$openId] = $number;
		$recordData['aidSource'] = $aidSource;
		$recordDoc->exchangeArray($recordData);
		$dm->persist($recordDoc);
		$dm->flush();
		$result = array(
			'status' => true,
			'msg' => $number
		);
		return new JsonModel($result);
	}
	
	public function delete($id)
	{
		return new JsonModel(array());
	}
}