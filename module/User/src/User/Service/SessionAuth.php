<?php
namespace User\Service;

use Zend\Session\Config\SessionConfig;
use Zend\Session\Storage\SessionStorage;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class SessionAuth
{
	protected $wxUser;
	
	public function __construct()
	{
		$sessionConfig = new SessionConfig();
		$sessionConfig->setOptions(array(
			'remember_me_seconds' => 86400,
			'use_cookies' => true,
			'cookie_httponly' => true,
		));
		
		$sessionManager = new SessionManager($sessionConfig);
		$sessionManager->start();
		$sessionManager->setStorage(new SessionStorage());
		
		Container::setDefaultManager($sessionManager);
		
		$this->wxUser = new Container('wx_user');
	}
	
	public function isLogin()
	{
		if($this->wxUser->openId) {
			return true;
		}
	}
	
	public function setOpenId($openId)
	{
		$this->wxUser->openId = $openId;
	}
	
	public function getOpenId()
	{
		return $this->wxUser->openId;
	}
}