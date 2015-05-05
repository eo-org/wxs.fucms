<?php

namespace Promotion\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 * collection="wx_promotion_probability_check"
 * )
 */
class ProbabilityCheck extends AbstractDocument
{
	/**
	 * @ODM\Id
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $openId;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $promotionId;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $promotionType;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $sn;
	
	/**
	 * @ODM\Field(type="boolean")
	 */
	protected $result;
	
	/**
	 * @ODM\Field(type="date")
	 */
	protected $created;
	
	public function exchangeArray($data)
	{
		if(isset($data['openId'])){
			$this->openId = $data['openId'];
		}
		
		if(isset($data['promotionId'])){
			$this->promotionId = $data['promotionId'];
		}
		
		if(isset($data['promotionType'])){
			$this->promotionType = $data['promotionType'];
		}
		
		if(isset($data['sn'])){
			$this->sn = $data['sn'];
		}
		
		if(isset($data['result'])){
			$this->result = $data['result'];
		}
		
		if(isset($data['created'])){
			$this->created = $data['created'];
		}
	}
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'openId' => $this->openId,
			'promotionId'	=> $this->promotionId,
			'promotionType'	=> $this->promotionType,
			'sn' => $this->sn,
			'result' => $this->result,
			'created' => $this->created,
			'createdTimestamp' => $this->created->getTimestamp()
		);
	}
}