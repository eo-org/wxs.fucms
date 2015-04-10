<?php
namespace Application\Service\Db;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\Common\Persistence\PersistentObject, Doctrine\ODM\MongoDB\DocumentManager, Doctrine\ODM\MongoDB\Configuration, Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver, Doctrine\MongoDB\Connection;

class WxsDocumentManagerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return DocumentManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
		$config = $serviceLocator->get('Config');
		$env = $config['env'];
		
		$host = '127.0.0.1';
		$dbName = 'wxs_fucms';
		
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
			'username' => 'wxs_admin',
			'password' => '2hsufoe(7690&6*',
			'db' => 'wxs_fucms'
		));
		$connection->initialize();
		$dm = DocumentManager::create($connection, $config);
		
		return $dm;
    }
}
