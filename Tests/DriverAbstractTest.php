<?php
use MemcachedRT\Config;
use MemcachedRT\DriverFactory;

include dirname(__FILE__) . '/../Library/Config.class.php';
include dirname(__FILE__) . '/../Library/DriverFactory.class.php';
include dirname(__FILE__) . '/../Library/DriverAbstract.class.php';
include dirname(__FILE__) . '/../Library/DriverMemcached.class.php';

// Start tests
class DriverAbstractTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Can we convert the uptime to a human readable form?
	 *
	 * @access public
	 */
	public function testUptimeConversion() {
		// Allow us to invoke the private method
		$driverAbstract        = new ReflectionClass('MemcachedRT\DriverAbstract');
		$convertUptimeToString = $driverAbstract->getMethod('convertUptimeToString');
		$convertUptimeToString->setAccessible(true);

		// Create instance of the abstract driver
		$driverAbstract = DriverFactory::get('memcached');

		// Some easy tests for the converter
		$this->assertEquals($convertUptimeToString->invokeArgs($driverAbstract, array(123)),      '00:02:03');
		$this->assertEquals($convertUptimeToString->invokeArgs($driverAbstract, array(1000)),     '00:16:40');
		$this->assertEquals($convertUptimeToString->invokeArgs($driverAbstract, array(10000)),    '02:46:40');
		$this->assertEquals($convertUptimeToString->invokeArgs($driverAbstract, array(100000)),   '1 day 03:46:40');
		$this->assertEquals($convertUptimeToString->invokeArgs($driverAbstract, array(1000000)),  '11 days 13:46:40');
		$this->assertEquals($convertUptimeToString->invokeArgs($driverAbstract, array(12345678)), '142 days 21:21:18');
	}
}