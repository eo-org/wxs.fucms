<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Document\User;

class FcUserBindController extends AbstractActionController
{
    public function indexAction()
    {
    	$redirect = $this->params()->fromQuery('redirect');
    	
    	$sm = $this->getServiceLocator();
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	 
    	$openId = $userAuth->getOpenId();
    	$dm = $sm->get('DocumentManager');
    	
    	if($this->getRequest()->isPost()) {
    		$loginName = $this->params()->fromPost('loginName');
    		$password = $this->params()->fromPost('password');
    		
    		$fcUserDoc = $dm->createQueryBulder('User\Document\CmsUser')
    			->field('loginName')->equals($loginName)
    			->field('password')->equasls($password)
    			->getSingleResult();
    		
    		if(is_null($userDoc)) {
    			$errorMsg = "账户不存在或者您输入的密码有误"
    		} else {
    			$userDoc = new User();
    			$userDoc->setId($openId);
    			$userDoc->setFcUserId($fcUserDoc->getId());
    			$dm->perist($userDoc);
    			
    			$dm->flush();
    		}
    	}
    	return array(
    		'errorMsg' => $errorMsg
		);	
	}
}