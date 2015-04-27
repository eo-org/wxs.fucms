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
	protected $value;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $promotion;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $promotionId;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $promotionLabel;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $sn;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $snLabel;
	
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
		
		if(isset($data['value'])){
			$this->value = $data['value'];
		}
		
		if(isset($data['promotion'])){
			$this->promotion = $data['promotion'];
		}
		
		if(isset($data['promotionId'])){
			$this->promotionId = $data['promotionId'];
		}
		
		if(isset($data['promotionLabel'])){
			$this->promotionLabel = $data['promotionLabel'];
		}
		
		if(isset($data['sn'])){
			$this->sn = $data['sn'];
		}
		
		if(isset($data['snLabel'])){
			$this->snLabel = $data['snLabel'];
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
			'value'	=> $this->value,
			'promotion'	=> $this->promotion,
			'promotionId'	=> $this->promotionId,
			'promotionLabel'	=> $this->promotionLabel,
			'sn' => $this->sn,
			'snLabel' => $this->snLabel,
			'result' => $this->result,
			'created' => $this->created,
		);
	}
}