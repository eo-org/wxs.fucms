<?php

namespace PromotionRest\Controller;


use MongoRegex;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

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
		return new JsonModel(array('a'=>'b'));
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