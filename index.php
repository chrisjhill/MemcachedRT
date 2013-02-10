<?php
use MemcacheRT\Config;
include dirname(__FILE__) . '/Library/Config.class.php';
?>

<!DOCTYPE html>
<html lang="en-gb">
<head>
	<meta charset="utf-8" />
	<meta name="author" content="http://github.com/chrisjhill" />
	<title>MemcachedRT | The Real Time Web Monitor</title>

	<link rel="stylesheet" href="<?=Config::get('webPath')?>assets/css/grid.css">
	<link rel="stylesheet" href="<?=Config::get('webPath')?>assets/css/layout.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700">

	<script>
	// Setup our graph information
	var graphMaxActionsPerSecond = <?=Config::get('graphMaxActionsPerSecond')?>;
	var graphSecondsToDisplay    = <?=Config::get('graphSecondsToDisplay')?>;
	var graphEnableAnimations    = <?=(int)Config::get('graphEnableAnimation')?>;

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
				<p><img src="<?=Config::get('webPath')?>assets/img/memcachedrt-small.png" alt="MemcachedRT | The Real Time Web Monitor" /></p>
			</div>

			<div class="col-1-2">
				<p id="host">
					<strong>Live monitoring:</strong>
					<?=Config::get('host')?>:<?=Config::get('portMemcached')?>
				</p>
			</div>
		</div>
	</header>

	<!-- Our live graph showing actions and evictions per second //-->
	<section id="graph-live" class="grid">
		<div class="col-1-1" id="memcached-graph-live"></div>
	</section>

	<!-- Comparison of statistics //-->
	<section id="graph-group-1">
		<div class="grid">
			<div class="graph-titles">
				<div class="col-1-3"><h2>Gets vs. Sets</h2></div>
				<div class="col-1-3"><h2>Hits vs. Misses vs. Evictions</h2></div>
				<div class="col-1-3"><h2>Space usage</h2></div>
			</div>
		</div>

		<div class="grid">
			<!-- Gets vs. Sets //-->
			<div class="col-1-3 graph" id="graph-actions">
				<div id="graph-actions-gets" class="status-good">&nbsp;</div>
				<div id="graph-actions-sets" class="status-fine">&nbsp;</div>
				<p>Actions: <span>Calculating&hellip;</span></p>
			</div>

			<!-- Hits vs. Misses vs. Evictions //-->
			<div class="col-1-3 graph" id="graph-status">
				<div id="graph-status-hits"      class="status-good">&nbsp;</div>
				<div id="graph-status-misses"    class="status-fine">&nbsp;</div>
				<div id="graph-status-evictions" class="status-bad">&nbsp;</div>
				<p>Status: <span>Calculating&nbsp;</span></p>
			</div>

			<!-- Space usage //-->
			<div class="col-1-3 graph" id="graph-space">
				<div id="graph-space-free" class="status-good">&nbsp;</div>
				<div id="graph-space-used" class="status-bad">&nbsp;</div>
				<p>Space: <span>Calculating&hellip;</span></p>
			</div>
		</div>
	</section>

	<!-- Static information //-->
	<section id="graph-group-2">
		<div class="grid">
			<div class="graph-titles">
				<div class="col-1-4"><h2>Uptime</h2></div>
				<div class="col-1-4"><h2>Items in Memcached</h2></div>
				<div class="col-1-4"><h2>Actions</h2></div>
				<div class="col-1-4"><h2>Connections</h2></div>
			</div>
		</div>

		<div class="grid">
			<!-- Uptime //-->
			<div class="col-1-4 graph" id="info-uptime">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>

			<!-- Items in Memcached //-->
			<div class="col-1-4 graph" id="info-items">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>

			<!-- Total actions performed //-->
			<div class="col-1-4 graph" id="info-actions">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>

			<!-- Current connections //-->
			<div class="col-1-4 graph" id="info-connections">
				<div class="status-good">&nbsp;</div>
				<p>Calculating&nbsp;</p>
			</div>
		</div>
	</section>

	<!-- Our nice splash screen //-->
	<section id="splash">
		<p><img src="<?=Config::get('webPath')?>assets/img/memcachedrt-big.png" alt="MemcachedRT | The Real Time Web Monitor" /></p>

		<h3>&nbsp;</h3>
	</section>

	<!-- Third Party Javascript //-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="//www.google.com/jsapi"></script>
	<script src="//js.pusher.com/1.12/pusher.min.js"></script>

	<!-- Our Javascript :) //-->
	<script src="<?=Config::get('webPath')?>assets/js/functions.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/graph.js"></script>
	<script src="<?=Config::get('webPath')?>assets/js/pusher.js"></script>
	<script>$(window).load(function() { $splash.fadeOut(1000); });</script>
</body>
</html>