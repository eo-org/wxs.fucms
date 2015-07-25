<?php
namespace Promotion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use WxDocument\Promotion\Smashing;

class SnInfoController extends AbstractActionController
{
	public function indexAction()
	{
		$websiteId = $this->params()->fromRoute('websiteId');
		
		$id = $this->params()->fromRoute('id');
		$sm = $this->getServiceLocator();
		$dm = $sm->get('DocumentManager');
		$snDoc = $dm->getRepository('WxDocument\Sn')->findOneById($id);
		$snData = $snDoc->getArrayCopy();
		
		$prizeDoc = $dm->getRepository('WxDocument\Promotion\Prize')->findOneById($snData['prizeId']);
		$prizeData = $prizeDoc->getArrayCopy();
		
		$promotionDoc = $dm->getRepository('WxDocument\Promotion\Smashing')->findOneById($prizeData['promotionId']);
		$promotionData = $promotionDoc->getArrayCopy();
		
		$result = array(
			'prizeName' => $prizeData['name'],
			'prizeType' => $prizeData['type'],
			'snCode' => $snData['serialCode'],
			'awardInfo' => $promotionData['awardInfo'],
			'websiteId'	=> $websiteId
		);
		
		return $result;
	}
}