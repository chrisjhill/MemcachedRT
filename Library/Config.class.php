<?php
/**
 * Configurations for the Memcached Real Time tracking.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       03/02/2013
 */
class Config
{
	/**
	 * The holder for all the config variables.
	 *
	 * @access private
	 * @var    array
	 * @static
	 */
	private static $_store = array();

	/**
	 * Load the users config file.
	 *
	 * @access public
	 * @static
	 */
	public static function load() {
		self::$_store = parse_ini_file(dirname(__FILE__) . '/config.ini', true);
	}

	/**
	 * Get a config variable.
	 *
	 * @param  string $variable The config to return.
	 * @return string
	 * @static
	 */
	public static function get($variable) {
		return isset(self::$_store[$variable])
			? self::$_store[$variable]
			: null;
	}
}

// A bit naughty, but heh-ho!
Config::load();