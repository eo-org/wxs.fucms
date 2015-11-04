<?php
namespace FileRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

require_once (BASE_PATH . "/inc/Qiniu/rs.php");
class QsTokenController extends AbstractRestfulController
{

	public function getList()
	{
		
	}

	public function get($id)
	{
		$config = $this->getServiceLocator()->get('Config');
		$bucket = $config['env']['qiniu']['bucket'];
		$accessKey = $config['env']['qiniu']['keyId'];
		$secretKey = $config['env']['qiniu']['keySecret'];
		
		Qiniu_SetKeys($accessKey, $secretKey);
		
		$putPolicy = new \Qiniu_RS_PutPolicy($bucket);
		$putPolicy->insertOnly = 1;
		$putPolicy->Expires = 10800;
		$putPolicy->ReturnBody = '{"key":$(key), "mimeType": $(mimeType), "ext": $(ext), "avinfo": $(avinfo)}';
		$uptoken = $putPolicy->Token(null);
		
		return new JsonModel(array('uptoken' => $uptoken));
	}

	public function create($data)
	{
		$websiteId = 'test-weixin-upload';
		
		$config = $this->getServiceLocator()->get('Config');
		$bucket = $config['env']['qiniu']['bucket'];
		$accessKey = $config['env']['qiniu']['keyId'];
		$secretKey = $config['env']['qiniu']['keySecret'];
		
		Qiniu_SetKeys($accessKey, $secretKey);
		
		$putPolicy = new \Qiniu_RS_PutPolicy($bucket);
		$putPolicy->insertOnly = 1;
		$putPolicy->Expires = 10800;
		$putPolicy->ReturnBody = '{"key":$(key), "mimeType": $(mimeType), "ext": $(ext), "avinfo": $(avinfo)}';
		$uptoken = $putPolicy->Token(null);
		
		
		return new JsonModel(array('uptoken' => $uptoken));
	}

	public function update($id, $data)
	{
		
	}

	public function delete($id)
	{
		
	}
}