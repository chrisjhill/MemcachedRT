<?php
use MemcachedRT\Config;
use MemcachedRT\DriverFactory;

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