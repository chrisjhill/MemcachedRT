<?php
use MemcachedRT\Config;
use MemcachedRT\DriverFactory;

include '../Library/Config.class.php';
include '../Library/DriverFactory.class.php';
include '../Library/DriverAbstract.class.php';
include '../Library/DriverMemcached.class.php';

// Start tests
class DriverFactoryTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Pass in a Memcache term we are unfamiliar with.
	 *
	 * @access public
	 * @expectedException InvalidArgumentException
	 */
	public function testUnknownMemcacheTerm() {
		// Get the Memcached instances
		self::$_instance = DriverFactory::get('foo');
	}
}