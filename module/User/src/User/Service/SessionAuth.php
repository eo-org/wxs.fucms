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
		if($this->wxUser->openid) {
			return true;
		}
		return false;
	}
	
	public function setOpenid($openid)
	{
		$this->wxUser->openid = $openid;
	}
	
	public function getOpenid()
	{
		return $this->wxUser->openid;
	}
	
	public function setUserData($data)
	{
		$this->wxUser->userData = $data;
	}
	
	public function getUserData()
	{
		return $this->wxUser->userData;
	}
}