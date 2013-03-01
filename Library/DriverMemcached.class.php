<?php
namespace MemcachedRT;

/**
 * * The Memcached driver object.
 *
 * @author Christopher Hill <cjhill@gmail.com>
 * @since  01/03/2013
 */
class DriverMemcached extends DriverAbstract
{
	/**
	 * Create an instance of Memcached.
	 *
	 * @access public
	 **/
	public function __construct() {
		$this->instance = new \Memcached();
	}

	/**
	 * Get the stats for this Memcached instance.
	 *
	 * @access public
	 * @return array
	 **/
	public function getRawStats() {
		$stats = $this->instance->getStats();
		return $stats[$this->hostPort];
	}
}