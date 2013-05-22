<?php
namespace MemcachedRT;

/**
 * Defines the interface for Memcache drivers and provides common functionality.
 *
 * @author Christopher Hill <cjhill@gmail.com>
 * @since  01/03/2013
 */
abstract class DriverAbstract {
	/**
	 * Internal driver instance.
	 *
	 * @access protected
	 * @var    object
	 */
	protected $instance;

	/**
	 * The host and port we wish to monitor.
	 *
	 * This only exists because when you call getStats() on a Memcache server it
	 * will return an array with the first index as 'host:port'. This is a quick
	 * reference to that index, which leads to a cleaner read.
	 *
	 * @access protected
	 * @var    string
	 */
	protected $hostPort;

	/**
	 * The live stats for this Memcache server.
	 *
	 * This is a reference of the values from the previous point in time.
	 *
	 * @access private
	 * @var    array
	 */
	private $_stats;

	/**
	 * Get the stats for this Memcached instance.
	 *
	 * @access   public
	 * @return   array
	 * @abstract
	 **/
	abstract function getRawStats();

	/**
	 * Add a Memcached server to the instance.
	 *
	 * @access public
	 * @param  string $host The host of the Memcached server.
	 * @param  string $port The port number for the Memcached server.
	 **/
	public function addServer($host, $port) {
		// Add the server instance
		$this->instance->addServer($host, $port);
		// Set the shorthand for the host and port index
		$this->hostPort = "$host:$port";
		// And set this servers initial stats
		$this->_stats = $this->getRawStats();
	}

	/**
	 * Returns an array of pre-manipulated stats.
	 *
	 * @access public
	 * @return boolean|array Boolean false on error, array if successful.
	 */
	public function getStats() {
		// Get the raw stats from
		$stats = $this->getRawStats();

		// Make sure that we have received valid data from Memcache
		if ($this->dataIsMalformed($stats)) {
			return false;
		}

		// Turn bytes into MB, and the uptime into a readable string
		$stats['limit_maxbytes'] = $stats['limit_maxbytes'] / 1024 / 1024;
		$stats['bytes']          = $stats['bytes']          / 1024 / 1024;
		$stats['uptime']         = $this->convertUptimeToString($stats['uptime']);

		// Turn the stats from all-time, to how many since we last observed
		$return = array(
			// Gets and sets
			'psGets'      => $stats['cmd_get']    - $this->_stats['cmd_get'],
			'psSets'      => $stats['cmd_set']    - $this->_stats['cmd_set'],
			'psHits'      => $stats['get_hits']   - $this->_stats['get_hits'],
			'psMisses'    => $stats['get_misses'] - $this->_stats['get_misses'],
			'psEvictions' => $stats['evictions']  - $this->_stats['evictions'],
			// Space
			'spaceTotal'  => $stats['limit_maxbytes'],
			'spaceFree'   => $stats['limit_maxbytes'] - $stats['bytes']
		);

		// We have now finished the live stats, so save the current stats
		$this->_stats = $stats;

		// And return the stats
		return array_merge($stats, $return);
	}

	/**
	 * Work out if the data we received from Memcache is valid.
	 *
	 * In an ideal world this function would not exist, however, in the wild
	 * there is a chance that the data will be malformed causing our graph
	 * to become wildly innacurate.
	 *
	 * @access private
	 * @param  array   $stats The data that we received from Memcache.
	 * @return boolean
	 */
	private function dataIsMalformed($stats) {
		// The indices that we require
		$requiredStats = array(
			'limit_maxbytes',
			'bytes',
			'cmd_get',
			'cmd_set',
			'get_hits',
			'get_misses',
			'evictions'
		);

		// Loop over each required piece of data and check it exists and is valid
		foreach ($requiredStats as $stat) {
			if (! isset($stats[$stat]) || empty($stats[$stat]) || $stats[$stat] < 0) {
				return false;
			}
		}

		// All the required stats seem to be present
		return true;
	}

	/**
	 * Convert how many seconds the server has been "up" into a human readable string.
	 *
	 * @access private
	 * @param  integer $uptimeInSeconds How many seconds the server has been "up".
	 * @return string                   A human readable uptime.
	 */
	private function convertUptimeToString($uptimeInSeconds) {
		// Work out the hours, mintues, and seconds
		$uptimeHourMinSecond = gmdate('H:i:s', $uptimeInSeconds);

		// Memcache server has been up for more than a day?
		if ($uptimeInSeconds >= 86400) {
			$dayQuantity = floor($uptimeInSeconds / 86400);

			return $dayQuantity
				. ($dayQuantity == 1 ? ' day ' : ' days ')
				. $uptimeHourMinSecond;
		}

		return $uptimeHourMinSecond;
	}
}