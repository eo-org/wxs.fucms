<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Document\User;

class FcUserBindController extends AbstractActionController
{
	protected $redirect = "";
	
    public function indexAction()
    {
    	$this->redirect = $this->params()->fromQuery('redirect');
    	$errorMsg = "";
    	$loginName = "";
    	
    	$sm = $this->getServiceLocator();
    	$userAuth = $sm->get('User\Service\SessionAuth');
    	 
    	$openid = $userAuth->getOpenid();
    	$dm = $sm->get('DocumentManager');
    	
    	$userDoc = $dm->getRepository('User\Document\User')->findOneByOpenid($openid);
    	$fcUserId = $userDoc->getFcUserId();
    	if(!empty($fcUserId)) {
    		$this->_jump();
    	}
    	
    	if($this->getRequest()->isPost()) {
    		$loginName = $this->params()->fromPost('loginName');
    		$password = $this->params()->fromPost('password');
    		
    		$fcUserDoc = $dm->createQueryBuilder('User\Document\CmsUser')
    			->field('loginName')->equals($loginName)
    			->field('password')->equals($password)
    			->getQuery()
    			->execute()
    			->getSingleResult();
    		
    		if(is_null($fcUserDoc)) {
    			$errorMsg = "账户不存在或者您输入的密码有误";
    		} else {
    			$dm->clear();
    			$userDoc = new User();
    			$userDoc->setOpenid($openid);
    			$userDoc->setFcUserId($fcUserDoc->getId());
    			$dm->persist($userDoc);
    			$dm->flush();
    			
    			$this->_jump();
    		}
    	}
    	return array(
    		'errorMsg' => $errorMsg,
    		'loginName' => $loginName
		);
	}
	
	protected function _jump()
	{
		if(empty($this->redirect)) {
			$this->redirect()->toRoute('user', array(), array(), true);
		} else {
			$this->redirect()->toUrl($this->redirect);
		}
	}
}