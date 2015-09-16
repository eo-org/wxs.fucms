<?php
namespace Application\Service\Db;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\Common\Persistence\PersistentObject, Doctrine\ODM\MongoDB\DocumentManager, Doctrine\ODM\MongoDB\Configuration, Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver, Doctrine\MongoDB\Connection;

class DocumentManagerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return DocumentManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
		$config = $serviceLocator->get('Config');
		$env = $config['env'];
		
    	$cmsSite = $serviceLocator->get('Application\Service\CmsSiteService');
    	
    	$serverArr = $cmsSite->getServerArr();
    	
		$host		= $serverArr['host'];
		$username	= $serverArr['username'];
		$password	= $serverArr['password'];
		$dbName		= $serverArr['dbName'];
		
		AnnotationDriver::registerAnnotationClasses();
		$config = new Configuration();
		$config->setDefaultDB($dbName);
		
		$config->setProxyDir(BASE_PATH . '/wxs.fucms/doctrineCache');
		$config->setProxyNamespace('DoctrineMongoProxy');
		$config->setHydratorDir(BASE_PATH . '/wxs.fucms/doctrineCache');
		$config->setHydratorNamespace('DoctrineMongoHydrator');
		$config->setMetadataDriverImpl(AnnotationDriver::create(BASE_PATH . '/class'));
		if($env['usage']['server'] == 'production') {
			$config->setAutoGenerateHydratorClasses(false);
			$config->setAutoGenerateProxyClasses(false);
		}
		$connection = new Connection($host, array(
			'username' => $username,
			'password' => $password,
			'db' => 'admin'
		));
		$connection->initialize();
		$dm = DocumentManager::create($connection, $config);
		
		return $dm;
    }
}
