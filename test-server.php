<?php
use MemcachedRT\Config;

/**
 * This is a simulation script of what interaction with a Memcached server
 * might look like. It is a never-ending script, you can initiate it the same
 * as the server.php file, via the PHP command line.
 *
 * It tries to spread the simulation over hits/sets/misses, so it will not look
 * exactly like production, but will give you a good enough example of what
 * this script will look like live.
 */

// Get the configs
include 'Library/Config.class.php';

// Setup Demcached
$memcached = new \Memcached();
$memcached->addServer(Config::get('host'), Config::get('port'));

// Start the infinite loop
while (true) {
	// This will generate between 500 and 2,000 Memecached actions per second
	for ($i = 0, $r = mt_rand(100, 400); $i <= $r; $i++) {
		// Make the set stats go up
		// We want about 3/4 gets and 1/4 sets
		// We want about 2/4 hits, 1/4 misses, and 1/4 evictions
		$memcachedVariable = 'foo' . mt_rand(0, 9999999);
		$memcached->set($memcachedVariable, 'bar');
		$memcached->get($memcachedVariable);
		$memcached->get($memcachedVariable);
		$memcached->get($memcachedVariable);
		$memcached->get('var-that-doesnt-exist');
	}

	// Output a message on the terminal so we know it's running
	echo date('jS F Y, G:i:s')
		. ': '
		. number_format($i * 5)
		. " simulations\n";

	// Sleep for a second, otherwise it will be going like the clappers!
	sleep(1);
}