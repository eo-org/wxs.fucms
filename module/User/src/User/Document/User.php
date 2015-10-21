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
	 * @ODM\Id
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $openid;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $fcUserId;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setOpenid($id)
	{
		$this->openid = $id;
	}
	
	public function setFcUserId($id)
	{
		$this->fcUserId = $id;
	}
	
	public function getFcUserId()
	{
		return $this->fcUserId;
	}
}