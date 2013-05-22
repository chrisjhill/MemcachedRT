<?php
use MemcachedRT\Config;
use MemcachedRT\DriverFactory;

// Start tests
class DriverMemcachedTest extends PHPUnit_Framework_TestCase
{
	/**
	 * The instance of the Memcached object.
	 *
	 * @access private
	 * @var    object
	 * @static
	 */
	private static $_instance;

	/**
	 * Can we get create a Memcached object?
	 *
	 * @access public
	 */
	public function testGetMemcacheObject() {
		// Get the Memcached instances
		self::$_instance = DriverFactory::get('memcached');

		// And the file has the correct contents?
		$this->assertEquals(get_class(self::$_instance), 'MemcachedRT\DriverMemcached');
	}

	/**
	 * Can we add a server?
	 *
	 * @access public
	 */
	public function testAddServer() {
		// Add the server
		self::$_instance->addServer('localhost', '11211');
	}

	/**
	 * Can we get the raw stats?
	 *
	 * @access public
	 */
	public function testCanGetRawStats() {
		// Get the raw stats (not manipulated)
		$rawStats = self::$_instance->getRawStats();

		// Do we have the key values?
		$this->assertArrayHasKey('limit_maxbytes', $rawStats);
		$this->assertArrayHasKey('bytes',          $rawStats);
		$this->assertArrayHasKey('uptime',         $rawStats);
		$this->assertArrayHasKey('cmd_get',        $rawStats);
		$this->assertArrayHasKey('cmd_set',        $rawStats);
		$this->assertArrayHasKey('get_hits',       $rawStats);
		$this->assertArrayHasKey('get_misses',     $rawStats);
		$this->assertArrayHasKey('evictions',      $rawStats);
	}

	/**
	 * Can we get the manipulated stats?
	 *
	 * @access public
	 */
	public function testCanGetManipulatedStats() {
		// Get the raw stats (not manipulated)
		$stats = self::$_instance->getStats();

		// Do we have the key values?
		$this->assertArrayHasKey('psGets',      $stats);
		$this->assertArrayHasKey('psSets',      $stats);
		$this->assertArrayHasKey('psHits',      $stats);
		$this->assertArrayHasKey('psMisses',    $stats);
		$this->assertArrayHasKey('psEvictions', $stats);
		$this->assertArrayHasKey('spaceTotal',  $stats);
		$this->assertArrayHasKey('spaceFree',   $stats);
	}
}