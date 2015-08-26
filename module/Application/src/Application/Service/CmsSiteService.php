<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CmsSiteService implements ServiceLocatorAwareInterface
{
	protected $sm;
	
	protected $websiteId;
	protected $serverArr;
	
	protected $internalIpAddress;
	protected $username;
	protected $password;
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->sm = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->sm;
	}
	
    public function getWebsiteId()
    {
		return $this->websiteId;
    }
    
    public function setWebsiteId($wid)
    {
    	$this->websiteId = $wid;
    }
    
    public function getServerArr()
    {
    	if(is_null($this->serverArr)) {
    		if(is_null($this->websiteId)) {
    			throw new \Exception('website id not set');
    		}
    		$config = $this->sm->get('Config');
    		
	    	$host = $config['account_fucms_db']['host'];
	    	$username = $config['account_fucms_db']['username'];
	    	$password = $config['account_fucms_db']['password'];
	    	$m = new \MongoClient($host, array(
	    		'username' => $username,
	    		'password' => $password,
	    		'db' => 'admin'
	    	));
	    	
	    	$db = $m->selectDb('account_fucms');
	    	$siteArr = $db->website->findOne(array(
	    		'_id' => new \MongoId($this->websiteId)
	    	));
	    	
	    	if(is_null($siteArr)) {
	    		header('Location: http://www.enorange.com/no-site/');
	    		exit(0);
	    	}
	    	if(! $siteArr['active']) {
	    		header('Location: http://www.enorange.com/site-expired/');
	    		exit(0);
	    	}
	    	
	    	$server = $db->server->findOne(array(
	    		'_id' => new \MongoId($siteArr['server']['$id'])
	    	));
	    	
	    	$this->internalIpAddress = $server['internalIpAddress'];
	    	$this->username = $server['user'];
	    	$this->password = $server['pass'];
	    	
	    	$this->serverArr = array(
	    		'host'		=> $this->internalIpAddress,
	    		'username'	=> $this->username,
	    		'password'	=> $this->password,
	    		'dbName'	=> 'cms_'.$siteArr['globalSiteId']
	    	);
    	}
    	
    	return $this->serverArr;
    }
}
