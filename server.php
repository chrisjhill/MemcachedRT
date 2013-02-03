<?php
// Get the configs
include dirname(__FILE__) . '/Library/Config.class.php';
include dirname(__FILE__) . '/Library/Pusher.class.php';

// Create the socket, and set it to non-blocking. In other words,
// .. socket_accept() does not wait for a new client before continuing.
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_set_nonblock($socket);
socket_bind($socket, Config::get('host'), Config::get('portServer'));

// Setup Demcached
$memcached = new Memcached();
$memcached->addServer(Config::get('host'), Config::get('portMemcached'));
$memcachedTotalHits = getHitTotal($memcached);

// Setup Pusher
$pusher = new Pusher(
	Config::get('pusherApiKey'),
	Config::get('pusherApiSecret'),
	Config::get('pusherAppId')
);

// Start the infinite loop
while (true) {
	// Get the new stats on Memcached
	$memcachedHitsThisSecond = getHitTotal($memcached) - $memcachedTotalHits;
	$memcachedTotalHits += $memcachedHitsThisSecond;

	// Push the message to Pusher
	$pusher->trigger('memcached', 'stat', array(
		'message' => $memcachedHitsThisSecond
	));

	// Output a message on the terminal so we know it's running
	echo date('jS F Y, G:i:s') . ": {$memcachedHitsThisSecond}\n";

	// Sleep for a second, otherwise it will be going like the clappers!
	sleep(1);
}

// Works out the total hits
function getHitTotal($memcached) {
	// Get the stats for this server
	$stats = $memcached->getStats();
	$stats = $stats[Config::get('host') . ':' . Config::get('portMemcached')];

	// And return the total of amount of hits
	return $stats['cmd_get'] + $stats['cmd_set']
		+ $stats['get_hits'] + $stats['get_misses'];
}

// close the listening socket
socket_close($socket);