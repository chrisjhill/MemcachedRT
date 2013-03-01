<?php
namespace MemcachedRT;

/**
 * Return a Memcache driver.
 *
 * PHP provides two primary memcached drivers: Memcached and Memcache. This
 * driver abstracts the differences away between them.
 *
 * 1. You can get an instance of a Memcache server via the following PHP:
 * $memcache = DriverFactory::get(Config::get('driver'));
 *
 * 2. You will then need to add your server:
 * $memcache->addServer(Config::get('host'), Config::get('port'));
 *
 * 3. And you can then get "live" stats by calling:
 * $memcache->getStats();
 *
 * @author Christopher Hill <cjhill@gmail.com>
 * @author 383 Project <hello@383project.com>
 * @since  02/02/2013
 */
class DriverFactory {
	/**
	 * Create a new Memcached driver.
	 *
	 * @access public
	 * @param  string $driver           The name of the driver that we want.
	 * @throws InvalidArgumentException If the driver is unknown to us.
	 * @throws RuntimeException         If the driver is not installed.
	 * @return object                   An instance of a Memcache server.
	 * @static
	 **/
	public static function get($driver) {
		// Are we aware of this driver?
		if (! in_array($driver, array('memcache', 'memcached'))) {
			throw new \InvalidArgumentException('Unexpected driver.');
		}

		// Make sure we have the driver installed
		else if (! class_exists($driver)) {
			throw new \RuntimeException('Could not locate the driver.');
		}

		// And return the instance of the Memcache driver
		switch ($driver) {
			case 'memcache':  return new DriverMemcache();  break;
			case 'memcached': return new DriverMemcached(); break;
		}
	}
}