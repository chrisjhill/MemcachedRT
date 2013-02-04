<?php
/**
 * This is a simulation script of what interaction with a Memcached server
 * might look like. It is a never-ending script, you can initiate it the same
 * as the server.php file, via the PHP command line.
 *
 * It tries to spread the simulation over hits/sets/misses, so it will not look
 * exactly like production, but will give you a good enough example of what
 * this script will look like live.
 *
 */

// Get the configs
include dirname(__FILE__) . '/Library/Config.class.php';

// Create the socket, and bind it to a port
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, Config::get('host'), Config::get('portServer') + 1);

// Setup Demcached
$memcached = new Memcached();
$memcached->addServer(Config::get('host'), Config::get('portMemcached'));

// Start the infinite loop
while (true) {
	// Get a random amount of variables
	for ($i = 0, $r = mt_rand(1, 500); $i <= $r; $i++) {
		// Make the set stats go up
		$memcachedVariable = 'foo' . mt_rand(0, 9999999999);
		$memcached->set($memcachedVariable, 'bar');

		// Simulate both hits and misses
		$memcached->get(mt_rand(0, 1) ? $memcachedVariable : 'var-that-doesnt-exist');
	}

	// Output a message on the terminal so we know it's running
	echo date('jS F Y, G:i:s') . "\n";

	// Sleep for a second, otherwise it will be going like the clappers!
	sleep(1);
}

// close the listening socket
socket_close($socket);