<?php
use MemcachedRT\Config;
use MemcachedRT\DriverFactory;

/**
 * Run this script in your terminal (php -q /path/to/this/file.php).
 *
 */

// Get the library files
include 'Library/Config.class.php';
include 'Library/DriverFactory.class.php';
include 'Library/DriverAbstract.class.php';
include 'Library/DriverMemcache.class.php';
include 'Library/DriverMemcached.class.php';
include 'Library/Pusher.class.php';

// Setup Memcache
$memcache = DriverFactory::get(Config::get('driver'));
$memcache->addServer(Config::get('host'), Config::get('port'));

// Setup Pusher
$pusher = new \Pusher(
	Config::get('pusherApiKey'),
	Config::get('pusherApiSecret'),
	Config::get('pusherAppId')
);

// Start the infinite loop
while (true) {
	// Get the new stats on Memcached
	$stats = $memcache->getStats();

	// Were we able to gather stats?
	if ($stats) {
		// Push the message to Pusher
		$pusher->trigger('memcached', 'stat', $stats);

		// Output a message on the terminal so we know it's running
		echo date('jS F Y, G:i:s')
			. ': '
			. number_format($stats['psGets'] + $stats['psGets'])
			. " actions\n";
	}

	// Sleep for a second, otherwise it will be going like the clappers!
	sleep(1);
}