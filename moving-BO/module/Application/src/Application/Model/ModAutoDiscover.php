<?php
namespace Application\Model;

use Zend\Code\Reflection\DocBlockReflection;
use Zend\Server\Reflection\ReflectionMethod;
use Zend\Soap\AutoDiscover;

/**
 * Class ModAutoDiscover
 *
 * @package Application\Mod\Zend\Soap\Wsdl
 */
class ModAutoDiscover extends AutoDiscover {

	/**
	 * @return \Zend\Soap\Wsdl
	 */
	protected function _generateClass()
	{
		$methods = $this->reflection->reflectClass($this->class)->getMethods();

		$_methods = $methods;
		foreach($_methods as $k=>$m){
			$scanner    = new DocBlockReflection(($m->getDocComment()) ? : '/***/');
			$skipTag = $scanner->getTags('notAutoDiscoverable');
			if(!is_array($skipTag) || !count($skipTag)){
				continue;
			}
			unset($methods[$k]);
		}

		return $this->_generateWsdl($methods);
	}

}