<?php
/**
 * Run this script in your terminal (php -q /path/to/this/file.php).
 *
 */

// Get the configs
include dirname(__FILE__) . '/Library/Config.class.php';
include dirname(__FILE__) . '/Library/Pusher.class.php';

// Setup Memcached
$memcached = new Memcached();
$memcached->addServer(Config::get('host'), Config::get('portMemcached'));

// Get the stats, and set how many hits there have been so far
$memcachedStats  = getMemcachedStats($memcached, array(
	'totalGets'      => 0,
	'totalSets'      => 0,
	'totalHits'      => 0,
	'totalMisses'    => 0,
	'totalEvictions' => 0
));
$memcachedTotals = array(
	'totalGets'      => $memcachedStats['cmdGet'],
	'totalSets'      => $memcachedStats['cmdSet'],
	'totalHits'      => $memcachedStats['getHits'],
	'totalMisses'    => $memcachedStats['getMisses'],
	'totalEvictions' => $memcachedStats['evictions']
);

// Setup Pusher
$pusher = new Pusher(
	Config::get('pusherApiKey'),
	Config::get('pusherApiSecret'),
	Config::get('pusherAppId')
);

// Start the infinite loop
while (true) {
	// Get the new stats on Memcached
	$memcachedStats  = getMemcachedStats($memcached, $memcachedTotals);
	$memcachedTotals['totalGets']      += $memcachedStats['psGets'];
	$memcachedTotals['totalSets']      += $memcachedStats['psSets'];
	$memcachedTotals['totalHits']      += $memcachedStats['psHits'];
	$memcachedTotals['totalMisses']    += $memcachedStats['psMisses'];
	$memcachedTotals['totalEvictions'] += $memcachedStats['psEvictions'];

	// Push the message to Pusher
	$pusher->trigger('memcached', 'stat', $memcachedStats);

	// Output a message on the terminal so we know it's running
	echo date('jS F Y, G:i:s') . ": Server\n";

	// Sleep for a second, otherwise it will be going like the clappers!
	sleep(1);
}

// Works out the total hits
function getMemcachedStats($memcached, $memcachedTotals) {
	// Get the stats for this server
	$stats = $memcached->getStats();
	$stats = $stats[Config::get('host') . ':' . Config::get('portMemcached')];

	// Turn bytes into MB
	$stats['limit_maxbytes'] = $stats['limit_maxbytes'] / 1024 / 1024;
	$stats['bytes']          = $stats['bytes']          / 1024 / 1024;

	// And return the total of amount of hits
	return array(
		// Standard Memcached stats
		'processId'        => $stats['pid'],
		'uptime'           => date('H:i:s', $stats['uptime']),
		'currItems'        => $stats['curr_items'],
		'totalItems'       => $stats['total_items'],
		'currConnections'  => $stats['curr_connections'],
		'totalConnections' => $stats['total_connections'],
		'cmdGet'           => $stats['cmd_get'],
		'cmdSet'           => $stats['cmd_set'],
		'getHits'          => $stats['get_hits'],
		'getMisses'        => $stats['get_misses'],
		'evictions'        => $stats['evictions'],

		// User created stats
		// Per second
		'psGets'           => $stats['cmd_get']    - $memcachedTotals['totalGets'],
		'psSets'           => $stats['cmd_set']    - $memcachedTotals['totalSets'],
		'psHits'           => $stats['get_hits']   - $memcachedTotals['totalHits'],
		'psMisses'         => $stats['get_misses'] - $memcachedTotals['totalMisses'],
		'psEvictions'      => $stats['evictions']  - $memcachedTotals['totalEvictions'],
		// Space
		'spaceTotal'       => $stats['limit_maxbytes'],
		'spaceFree'        => $stats['limit_maxbytes'] - $stats['bytes']
	);
}