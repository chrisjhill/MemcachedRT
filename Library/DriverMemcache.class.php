<?php
namespace MemcachedRT;

/**
 * * The Memcache driver object.
 *
 * @author Christopher Hill <cjhill@gmail.com>
 * @since  01/03/2013
 */
class DriverMemcache extends DriverAbstract
{
	/**
	 * Create an instance of Memcache.
	 *
	 * @access public
	 **/
	public function __construct() {
		$this->instance = new \Memcache();
	}

	/**
	 * Get the stats for this Memcache instance.
	 *
	 * @access public
	 * @return array
	 **/
	public function getRawStats() {
		$stats = $this->instance->getExtendedStats();
		return $stats[$this->hostPort];
	}
}