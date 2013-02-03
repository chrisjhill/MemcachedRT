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
	<div id="memcached-graph"></div>

	<!-- Third Party Javascript //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="http://js.pusher.com/1.12/pusher.min.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/flot/flot.js"></script>
	<!-- Our Javascript :) //-->
	<script src="<?=Config::get('webPath')?>assets/js/pusher.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/graph.js"></script>
</body>
</html>