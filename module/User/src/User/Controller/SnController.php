<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class SnController extends AbstractActionController
{
    public function indexAction()
    {
    	$userAuth = $this->getServiceLocator()->get('User\Service\SessionAuth');
    	$openId = $userAuth->getOpenId();
    	
    	$dm = $this->getServiceLocator()->get('DocumentManager');
    	
    	$snDocs = $dm->createQueryBuilder('WxDocument\Sn')
    		->field('openId')->equals($openId)
    		->field('status')->equals('used')
    		->getQuery()
    		->execute();
    	
    	return array(
    		'snDocs' => $snDocs
    	);	
    }
}