<?php
namespace FileRest\Controller;

use WxDocument\File;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class FileController extends AbstractRestfulController
{
	public function getList()
	{
		return new JsonModel();
	}
	
	public function get($id)
	{
		return new JsonModel();
	}
	
	public function create($data)
	{
		$sm = $this->getServiceLocator();
		$userAuth = $sm->get('User\Service\SessionAuth');
		$openid = $userAuth->getOpenid();
		
		$dm = $sm->get('DocumentManager');
		
		$fileDoc = new File();
		$fileDoc->setOpenid($openid);
		$fileDoc->exchangeArray($data);
		$dm->persist($fileDoc);
		$dm->flush();
		
		return new JsonModel(array($data));
	}
	
	public function update($id, $data)
	{
		
	}
	
	public function delete($id)
	{
				
	}
}