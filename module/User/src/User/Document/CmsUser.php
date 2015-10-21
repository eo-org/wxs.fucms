<?php
namespace User\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 * collection="user"
 * )
 */
class CmsUser
{
	/**
	 * @ODM\Id
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $loginName;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $password;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $avatar;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $userGroup = 'online';
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $status = 'active';
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $birthday;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $address;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $province;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $city;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $county;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $detailedAddress;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $tel;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $sex;
	
	/**
	 * @ODM\Field(type="hash")
	 */
	protected $link;
	
	/**
	 * @ODM\Field(type="hash")
	 */
	protected $data;
	
	/**
	 * @ODM\Field(type="date")
	 */
	protected $created;
	protected $inputFilter;
	protected $dm;
	
	public function setDocumentManager($dm)
	{
		$this->dm = $dm;
	}
	
	public function getInputFilter()
	{
		if(! $this->inputFilter) {
			$inputFilter = new InputFilter();
			$inputFactory = new FilterFactory();
			
			$inputFilter->add($inputFactory->createInput(array(
				'name' => 'loginName',
				'requried' => true,
				'filters' => array(
					array(
						'name' => 'StringTrim'
					)
				),
				'validators' => array(
					array(
						'name' => 'NotEmpty'
					),
					// array('name' => 'EmailAddress'),
					array(
						'name' => '\Cms\Validator\DbExists',
						'options' => array(
							'dm' => $this->dm,
							'repository' => '\User\Document\User',
							'field' => 'loginName',
							'skip' => $this->id
						)
					)
				)
			)));
			$inputFilter->add($inputFactory->createInput(array(
				'name' => 'password',
				'requried' => true,
				'filters' => array(
					array(
						'name' => 'StringTrim'
					)
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 6,
							'max' => 18
						)
					)
				)
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	public function exchangeArray($data)
	{
		$detailedAddress;
		if($data['loginName']){
			$this->loginName = $data['loginName'];
		}
		
		if($data['password']){
			$this->password = $data['password'];
		}		
		
		if(isset($data['status'])){
			$this->status = $data['status'];
		}
		
		if(isset($data['userGroup'])){
			$this->userGroup = $data['userGroup'];
		}
		
		if(isset($data['sex'])){
			$this->sex = $data['sex'];
		}
		
		if(isset($data['birthday'])){
			$this->birthday = $data['birthday'];
		}
		
		if(isset($data['tel'])){
			$this->tel = $data['tel'];
		}
		
		if(isset($data['province'])){
			$this->province = $data['province'];
			$detailedAddress = $data['province'];
		}
		
		if(isset($data['city'])){
			$this->city = $data['city'];
			$detailedAddress = $detailedAddress.$data['city'];
		}
		
		if(isset($data['county'])){
			$this->county = $data['county'];
			$detailedAddress = $detailedAddress.$data['county'];
		}
		
		if(isset($data['address'])){
			$this->address = $data['address'];
			$detailedAddress = $detailedAddress.$data['address'];
		}
		
		if(!empty($detailedAddress)){
			$this->detailedAddress = $detailedAddress;
		}		
		// $dataArr = array();
		// foreach($data as $key => $val) {
		
		// if(substr($key, 0, 5) == 'data_') {
		// $newKey = substr($key, 5);
		// $dataArr[$newKey] = $val;
		// }
		// }
		// $this->data = $dataArr;
	}
	
	public function getArrayCopy()
	{
		$dataArr = array(
			'id' => $this->id,
			'loginName' => $this->loginName,
			'password' => $this->password,
			'status' => $this->status,
			'userGroup'	=>$this->userGroup,
			'avatar'	=> $this->avatar,
			'sex'	=> $this->sex,
			'tel'	=> $this->tel,
			'birthday'	=> $this->birthday,
			'province' => $this->province,
			'city'	=> $this->city,
			'county' => $this->county,
			'address' => $this->address,
			'detailedAddress' => $this->detailedAddress,
		);
		if($this->data) {
			$dataArr['data'] = $this->data;
		}
		return $dataArr;
	}
	
	public function setLink($key, $data)
	{
		$this->link[$key] = $data;
	}
	
	public function getId()
	{
		return $this->id;
	}
}