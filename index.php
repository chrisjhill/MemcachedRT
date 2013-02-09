<?php include dirname(__FILE__) . '/Library/Config.class.php'; ?>

<!DOCTYPE html>
<html lang="en-gb">
<head>
	<meta charset="utf-8" />
	<meta name="author" content="http://github.com/chrisjhill" />
	<title>Memcached | The Real Time Web Monitor</title>

	<link rel="stylesheet" href="<?=Config::get('webPath')?>assets/css/grid.css">
	<link rel="stylesheet" href="<?=Config::get('webPath')?>assets/css/layout.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700">

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
	<header>
		<div class="grid">
			<div class="col-1-2">
				<p><img src="<?=Config::get('webPath')?>assets/img/memcachedrt-small.png" alt="Memcached | The Real Time Web Monitor" /></p>
				
				<p id="host"><strong>Live monitoring</strong>: <?=Config::get('host')?>:<?=Config::get('portMemcached')?></p>
			</div>
		</div>
	</header>
	
	<section id="graph-live">
		<div class="grid">
			<div class="col-1-1" id="memcached-graph-live"></div>
		</div>
	</section>
	
	<section id="graph-group-1">
		<div class="grid">
			<div id="graph-titles">
				<div class="col-1-3"><h2>Gets vs. Sets</h2></div>
				<div class="col-1-3"><h2>Hits vs. Misses vs. Evictions</h2></div>
				<div class="col-1-3"><h2>Space usage</h2></div>
			</div>

			<div class="col-1-3 graph" id="graph-actions">
				<div id="graph-actions-gets" class="status-good">&nbsp;</div>
				<div id="graph-actions-sets" class="status-fine">&nbsp;</div>
				<p>Actions: <span>Calculating&hellip;</span></p>
			</div>

			<div class="col-1-3 graph" id="graph-status">
				<div id="graph-status-hits"      class="status-good">&nbsp;</div>
				<div id="graph-status-misses"    class="status-fine">&nbsp;</div>
				<div id="graph-status-evictions" class="status-bad">&nbsp;</div>
				<p>Status: <span>Calculating&nbsp;</span></p>
			</div>
			
			<div class="col-1-3 graph" id="graph-space">
				<div id="graph-space-used" class="status-bad">&nbsp;</div>
				<div id="graph-space-free" class="status-good">&nbsp;</div>
				<p>Space: <span>Calculating&hellip;</span></p>
			</div>
		</div>
	</section>
	
	<section id="graph-group-2">
		<div class="grid">		
			<div id="graph-titles">
				<div class="col-1-4"><h2>Uptime</h2></div>
				<div class="col-1-4"><h2>Items in Memcached</h2></div>
				<div class="col-1-4"><h2>Actions</h2></div>
				<div class="col-1-4"><h2>Connections</h2></div>
			</div>
			
			<div class="col-1-4 graph" id="info-uptime">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>
			
			<div class="col-1-4 graph" id="info-items">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>
			
			<div class="col-1-4 graph" id="info-actions">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>
			
			<div class="col-1-4 graph" id="info-connections">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>
		</div>
	</section>
	
	<section id="splash">
		<img src="<?=Config::get('webPath')?>assets/img/memcachedrt-big.png" alt="Memcached | The Real Time Web Monitor" />
		<h3>Loading application&hellip;</h3>
	</section>

	<!-- Third Party Javascript //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="https://www.google.com/jsapi"></script>
	<script src="http://js.pusher.com/1.12/pusher.min.js"></script>
	<!-- Our Javascript :) //-->
	<script src="<?=Config::get('webPath')?>assets/js/functions.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/graph.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/pusher.js"></script>
	<script>$(window).load(function() { $("#splash").fadeOut(1000); });</script>
</body>
</html>