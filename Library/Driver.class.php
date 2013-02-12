<?php
namespace MemcacheRT;

/**
 * Drivers for interacting with memcached
 *
 * PHP provides two primary memcached drivers: Memcached
 * and Memcache. This driver abstracts the differences away
 * between them. In an ideal world, this would merely act
 * as a wrapper around the actual drivers, but in this
 * instance, switch statements will suffice.
 *
 * @author      383 Project <hello@383project.com>
 * @since       02/02/2013
 */
class Driver {


	/**
	 * Create a new Memcached driver
	 *
	 * @access public
	 * @static
	 **/
	public static function factory($driver) {
		return new Driver($driver);
	}


	/**
	 * Internal driver name
	 *
	 * @access protected
	 * @var    string
	 */
	protected $driver_name;


	/**
	 * Internal driver instance
	 *
	 * @access protected
	 * @var    object
	 */
	protected $driver_inst;


	/**
	 * New Memcached driver
	 *
	 * @access public
	 **/
	public function __construct($driver) {

		$driver = strtolower($driver);

		switch($driver) {

			case 'memcache':
				if(!class_exists('Memcache')) trigger_error('Driver "Memcache" not found', E_USER_ERROR);
				$this->driver_name = 'Memcache';
				$this->driver_inst = new \Memcache;
				break;

			case 'memcached':
			default:
				if(!class_exists('Memcached')) trigger_error('Driver "Memcached" not found', E_USER_ERROR);
				$this->driver_name = 'Memcached';
				$this->driver_inst = new \Memcached;
				break;

		}

	}


	/**
	 * Add Memcached server
	 *
	 * @access public
	 **/
	public function addServer($host, $port) {
		$this->driver_inst->addServer($host, $port);
	}


	/**
	 * Add Memcached server
	 *
	 * @access public
	 **/
	public function getStats($host, $port) {

		switch($this->driver_name) {

			case 'Memcache':
				return $this->driver_inst->getExtendedStats();
				break;

			case 'Memcached':
				return $this->driver_inst->getStats();
				break;

		}

		return false;

	}


}