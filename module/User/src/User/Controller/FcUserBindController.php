<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Document\User;

class FcUserBindController extends AbstractActionController
{
	private static $_md5salt1 = 'Hgoc&639Jgo';
	private static $_md5salt2 = 'bis^%Jfn)32n';
	
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
    	
    	if($userDoc) {
    		$fcUserId = $userDoc->getFcUserId();
	    	if(!empty($fcUserId)) {
	    		$this->_jump();
	    	}
    	}
    	
    	if($this->getRequest()->isPost()) {
    		$loginName = trim($this->params()->fromPost('loginName'));
    		$password = $this->params()->fromPost('password');
    		$md5Password = $this->getMd5Password($password);
    		$userDoc = $dm->getRepository('User\Document\User')->findOneByFcUserLoginName($loginName);
    		
    		if($userDoc) {
    			return array(
    				'errorMsg' => $loginName.'已经绑定微信号！此帐号不能重复绑定',
    				'loginName' => $loginName
    			);
    		}
    		
    		$fcUserDoc = $dm->createQueryBuilder('User\Document\CmsUser')
    			->field('loginName')->equals($loginName)
    			->field('password')->equals($md5Password)
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
    			$userDoc->setFcUserLoginName($loginName);
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
	
	public function getMd5Password($password)
	{
		return md5(self::$_md5salt1 . $password . self::$_md5salt2);
	}
}