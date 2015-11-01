<?php
namespace Application\Service\Db;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Redis;

class RedisClientFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Redis
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
		$sm = $serviceLocator;
		
		$fileConfig = $sm->get('Config');
		$env = $fileConfig['auth']['redis'];
		
		$host = $env['host'];
		$pass = $env['pass'];
		
		$redisClient = new Redis();
		
		$redisClient->connect($host);
		$redisClient->auth($pass);
		
		return $redisClient;
    }
}