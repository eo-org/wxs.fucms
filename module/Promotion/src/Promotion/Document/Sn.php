<?php
namespace Promotion\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 * collection="wx_promotion_sn"
 * )
 */
class Sn
{
	/**
	 * @ODM\Id
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $prizeId;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $status = 'new';
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $serialCode;
	
// 	/**
// 	 * @ODM\Field(type="string")
// 	 */
// 	protected $serialCode;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $approvedByLabel;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $approvedById;
	
	public function exchangeArray($data)
	{
		
	}
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'serialCode' => $this->serialCode,
		);
	}
	
	public function setPrizeId($value)
	{
		$this->prizeId = $value;
	}
	
	public function setSerialCode($value)
	{
		$this->serialCode = $value;
	}
	
	public function setStatus($value)
	{
		$this->status = $value;
	}
}