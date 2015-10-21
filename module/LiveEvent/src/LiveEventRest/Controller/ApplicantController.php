<?php
namespace LiveEventRest\Controller;

use WxDocument\LiveEvent\Applicant;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ApplicantController extends AbstractRestfulController
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
		$applicantDoc = new Applicant();
		$applicantDoc->exchangeArray($data);
		$applicantDoc->setOpenid($openid);
		$dm->persist($applicantDoc);
		$dm->flush();
		
		return new JsonModel(array('id' => $applicantDoc->getId()));
	}
	
	public function update($id, $data)
	{
		$dm = $this->getServiceLocator()->get('DocumentManager');
		$applicantDoc = $dm->getRepository('WxDocument\LiveEvent\Applicant')
			->findOneById($id);
		if(is_null($applicantDoc)) {
			throw new \Exception('document not found');
		}
		$applicantDoc->exchangeArray($data);
		$dm->persist($applicantDoc);
		$dm->flush();
		
		return new JsonModel(array('id' => $applicantDoc->getId()));
	}
	
	public function delete($id)
	{
				
	}
}