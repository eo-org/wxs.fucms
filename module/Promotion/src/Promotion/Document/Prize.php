<?php
namespace Promotion\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use Weixin\Document\Sn;

/**
 * @ODM\Document(
 * collection="wx_promotion_prize"
 * )
 */
class Prize extends AbstractDocument
{
	/**
	 * @ODM\Id
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $name;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $type;
	
	/**
	 * @ODM\Field(type="int")
	 */
	protected $quantity;
	
	/**
	 * @ODM\Field(type="int")
	 */
	protected $remainderCounter;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $promotionId;
	
	public function exchangeArray($data)
	{
		if(isset($data['name'])){
			$this->name = $data['name'];
		}
		
		if(isset($data['type'])){
			$this->type = $data['type'];
		}
		
		if(isset($data['quantity'])){
			$this->quantity = $data['quantity'];
		}
		
		if(is_null($this->remainderCounter)) {
			$this->remainderCounter = $data['quantity'];
		}
		
		if(isset($data['promotionId'])){
			$this->promotionId = $data['promotionId'];
		}
	}
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'name' => $this->name,
			'type' => $this->type,
			'quantity' => $this->quantity,
			'remainderCounter' => $this->remainderCounter,
			'promotionId' => $this->promotionId,
		);
	}
	
	public function setRemainderCounter($value)
	{
		$this->remainderCounter = $value;
	}
}