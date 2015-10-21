<?php
namespace User\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 * collection="wx_user"
 * )
 */
class User
{
	/**
	 * @ODM\Id((strategy="none"))
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $name;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $fcUserId;
	
	public function exchangeArray($data)
	{
		$this->name = $data['name'];
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setFcUserId($id)
	{
		$this->fcUserId = $id;
	}
}