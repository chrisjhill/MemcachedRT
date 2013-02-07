<?php include dirname(__FILE__) . '/Library/Config.class.php'; ?>

<!DOCTYPE html>
<html lang="en-gb">
<head>
	<meta charset="utf-8"/>
	<meta name="author" content="http://github.com/chrisjhill"/>
	<title>Memcached Real Time Hits-Per-Second Graph</title>

	<link href="<?=Config::get('webPath')?>assets/css/layout.css" rel="stylesheet" />

	<script>
	// What is considered the max amount of memcached hits per second before Eeek!
	var maxMemcachedHitsPerSecond = <?=Config::get('memcacheMaxHitsPerSecond')?>;

	// How many seconds we want to log (300 = 5 minutes)
	var seconds = <?=Config::get('memcacheNumberOfSecondsToMonitor')?>;

	// Setup our Pusher information
	var pusherApiKey  = "<?=Config::get('pusherApiKey')?>";
	var pusherChannel = "<?=Config::get('pusherChannel')?>";
	var pusherEvent   = "<?=Config::get('pusherEvent')?>";
	</script>
</head>
<body>
	<h1>Your Memcached server running on <?=Config::get('host')?>:<?=Config::get('portMemcached')?></h1>

	<div class="container">
		<div class="grid">
			<div id="memcached-graph-hps"></div>
		</div>

		<div class="grid">
			<div id="memcached-graph-space"></div>
		</div>
	</div>

	<table>
		<tr>
			<th>Current items</th>
			<td id="stat-current-items">Calculating&hellip;</td>
			<th>Uptime</th>
			<td id="stat-uptime">Calculating&hellip;</td>
		</tr>
		<tr>
			<th>Total reads</th>
			<td id="stat-reads">Calculating&hellip;</td>
			<th>Process ID</th>
			<td id="stat-process-id">Calculating&hellip;</td>
		</tr>
		<tr>
			<th>Total read hits</th>
			<td id="stat-read-hits">Calculating&hellip;</td>
			<th>Current connections</th>
			<td id="stat-cur-connections">Calculating&hellip;</td>
		</tr>
		<tr>
			<th>Total read misses</th>
			<td id="stat-read-misses">Calculating&hellip;</td>
			<th>Total connections</th>
			<td id="stat-total-connections">Calculating&hellip;</td>
		</tr>
		<tr>
			<th>Total sets</th>
			<td id="stat-sets" style="width:200px">Calculating&hellip;</td>
			<th>Total space</th>
			<td id="stat-space-total">Calculating&hellip;</td>
		</tr>
		<tr>
			<th>Evictions</th>
			<td id="stat-evictions" style="width:200px">Calculating&hellip;</td>
			<th>Space available</th>
			<td id="stat-space-free">Calculating&hellip;</td>
		</tr>
	</table>

	<!-- Third Party Javascript //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="https://www.google.com/jsapi"></script>
	<script src="http://js.pusher.com/1.12/pusher.min.js"></script>
	<!-- Our Javascript :) //-->
	<script src="<?=Config::get('webPath')?>assets/js/pusher.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/graph-hps.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/graph-space.js"></script>
</body>
</html>