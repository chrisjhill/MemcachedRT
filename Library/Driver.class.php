<?php
namespace MemcacheRT;

/**
 * Drivers for interacting with memcached
 *
 * PHP provides two primary memcached drivers: Memcached and Memcache. This
 * driver abstracts the differences away between them. In an ideal world, this
 * would merely act as a wrapper around the actual drivers, but in this
 * instance, switch statements will suffice.
 *
 * @author      383 Project <hello@383project.com>
 * @since       02/02/2013
 */
class Driver {
	/**
	 * Internal driver name, either "Memcached" or "Memcache".
	 *
	 * @access protected
	 * @var    string
	 */
	protected $_driverName;

	/**
	 * Internal driver instance.
	 *
	 * @access protected
	 * @var    object
	 */
	protected $_driverInstance;

	/**
	 * Create a new Memcached driver.
	 *
	 * @access public
	 * @param  string $driverName Internal driver name.
	 * @static
	 **/
	public static function factory($driverName) {
		return new Driver($driverName);
	}

	/**
	 * New Memcached driver
	 *
	 * @access public
	 * @param  string $driverName Internal driver name.
	 **/
	public function __construct($driverName) {
		switch (strtolower($driverName)) {
			case 'memcache':
				if (! class_exists('Memcache')) {
					trigger_error('Driver "Memcache" not found', E_USER_ERROR);
				}

				$this->_driverName     = 'Memcache';
				$this->_driverInstance = new \Memcache;
				break;

			default:
				if (! class_exists('Memcached')) {
					trigger_error('Driver "Memcached" not found', E_USER_ERROR);
				}

				$this->_driverName     = 'Memcached';
				$this->_driverInstance = new \Memcached;
		}
	}

	/**
	 * Add Memcached server to the instance.
	 *
	 * @access public
	 * @param  string $host The host of the Memcached server.
	 * @param  string $port The port number for the Memcached server.
	 **/
	public function addServer($host, $port) {
		$this->_driverInstance->addServer($host, $port);
	}

	/**
	 * Get the stats for this Memcached instance.
	 *
	 * @access public
	 * @return array
	 **/
	public function getStats() {
		switch ($this->_driverName) {
			case 'Memcache':
				return $this->_driverInstance->getExtendedStats();
				break;

			default:
				return $this->_driverInstance->getStats();
		}

		return false;
	}
}