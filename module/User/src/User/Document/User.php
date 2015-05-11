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
}