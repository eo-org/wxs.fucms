<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class OutputImage extends AbstractHelper implements ServiceLocatorAwareInterface
{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;
	
	public function __invoke($filename, $width = null, $height = null)
    {
    	$sm = $this->getServiceLocator()->getServiceLocator();
    	
    	$cmsSite = $sm->get('Application\Service\CmsSiteService');
    	$websiteId = $cmsSite->getWebsiteId();
    	
    	//$siteConfig = $sm->get('ConfigObject\EnvironmentConfig');
		//$websiteId = $siteConfig->getWebsiteId();
		//$cdnStamp = $siteConfig->getCdnStamp();
		
		$config = $sm->get('Config');
		$folderPath = $config['env']['path']['qiniu'];
		
		$folder = $folderPath . '/' . $websiteId;
		if($width == null && $height == null) {
			return $folder . '/' . $filename;
		} else {
			return $folder . '/' . $filename.'?imageView2/1/w/'.$width.'/h/'.$height;
		}
    }
}
