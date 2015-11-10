<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class SubText extends AbstractHelper
{
	public function __invoke($str, $length, $suffix, $charset = 'UTF8')
	{
		//if(function_exists("mb_substr")) {
		if(mb_strlen($str, $charset) <= $length)
			return $str;
		$slice = mb_substr($str, 0, $length, $charset);
		if($suffix)
			return $slice . $suffix;
		return $slice;
	}
}