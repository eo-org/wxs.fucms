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
	protected $label;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $status = 'new';
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $serialCode;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $openId;
	
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
			'prizeId' => $this->prizeId,
			'openId' => $this->openId,
			'status' => $this->status,
			'approvedById' => $this->approvedById,
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
	
	public function setOpenId($value)
	{
		$this->openId = $value;
	}
}