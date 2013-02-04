<?php
/**
 * Run this script in your terminal (php -q /path/to/this/file.php).
 *
 */

// Get the configs
include dirname(__FILE__) . '/Library/Config.class.php';
include dirname(__FILE__) . '/Library/Pusher.class.php';

// Create the socket, and bind it to a port
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, Config::get('host'), Config::get('portServer'));

// Setup Memcached
$memcached = new Memcached();
$memcached->addServer(Config::get('host'), Config::get('portMemcached'));

// Get the stats, and set how many hits there have been so far
$memcachedStats     = getMemcachedStats($memcached);
$memcachedTotalHits = $memcachedStats['hitsPerSecond'];

// Setup Pusher
$pusher = new Pusher(
	Config::get('pusherApiKey'),
	Config::get('pusherApiSecret'),
	Config::get('pusherAppId')
);

// Start the infinite loop
while (true) {
	// Get the new stats on Memcached
	$memcachedStats      = getMemcachedStats($memcached, $memcachedTotalHits);
	$memcachedTotalHits += $memcachedStats['hitsPerSecond'];

	// Push the message to Pusher
	$pusher->trigger('memcached', 'stat', $memcachedStats);

	// Output a message on the terminal so we know it's running
	echo date('jS F Y, G:i:s') . ": {$memcachedStats['hitsPerSecond']}\n";

	// Sleep for a second, otherwise it will be going like the clappers!
	sleep(1);
}

// Works out the total hits
function getMemcachedStats($memcached, $memcachedTotalHits = 0) {
	// Get the stats for this server
	$stats = $memcached->getStats();
	$stats = $stats[Config::get('host') . ':' . Config::get('portMemcached')];

	// And return the total of amount of hits
	return array(
		// Generic Memcached stats
		'processId'        => $stats['pid'],
		'uptime'           => date('H:i:s', $stats['uptime']),
		'currItems'        => number_format($stats['curr_items']),
		'totalItems'       => number_format($stats['total_items']),
		'currConnections'  => number_format($stats['curr_connections']),
		'totalConnections' => number_format($stats['total_connections']),
		'cmdGet'           => number_format($stats['cmd_get']),
		'cmdSet'           => number_format($stats['cmd_set']),
		'getHits'          => number_format($stats['get_hits']),
		'getMisses'        => number_format($stats['get_misses']),
		'evictions'        => number_format($stats['evictions']),

		// User created stats
		'hitsPerSecond'    => ($stats['cmd_get'] + $stats['cmd_set']) - $memcachedTotalHits
	);
}

// close the listening socket
socket_close($socket);