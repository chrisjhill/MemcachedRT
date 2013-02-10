// Setup our Pusher information
var pusher        = new Pusher(pusherApiKey);
var pusherChannel = pusher.subscribe(pusherChannel);

// Set references to the DOM to avoid lookups on each push
// Types of action
$graphActionsGets     = $("#graph-actions-gets");
$graphActionsSets     = $("#graph-actions-sets");
$graphActionsP        = $("#graph-actions p");
// Action statuses
$graphStatusHits      = $("#graph-status-hits");
$graphStatusMisses    = $("#graph-status-misses");
$graphStatusEvictions = $("#graph-status-evictions");
$graphStatusP         = $("#graph-status p");
// Space
$graphFreeSpace       = $("#graph-space-free");
$graphSpaceUsed       = $("#graph-space-used");
$graphSpaceP          = $("#graph-space p");
// General information
$infoUptimeP         = $("#info-uptime p");
$infoItemsP          = $("#info-items p");
$infoActionsP        = $("#info-actions p");
$infoConnectionsP    = $("#info-connections p");
// The splash screen
$splash              = $("#splash");
var pusherUpdated    = new Date();
var showSplash       = true;

// This function is called when we receive a push event
pusherChannel.bind(pusherEvent, function(data) {
	// Set our last update, and allow splash screen to be shown
	pusherUpdated = new Date();
	showSplash    = true;

	// Actions and evictions per second
	drawChart(
		getData((data.psGets + data.psSets),
		data.psEvictions)
	);

	// Types of action
	var totalActions = data.psGets + data.psSets;
	var getPercent   = (data.psGets / totalActions) * 100;
	var setPercent   = (data.psSets / totalActions) * 100;

	$graphActionsGets.width(getPercent + "%");
	$graphActionsSets.width(setPercent + "%");
	$graphActionsP.html("Gets: <code>"
		+ data.psGets
		+ "</code>, Sets: <code>"
		+ data.psSets
		+ "</code>");

	// Action statuses
	var totalStatus      = data.psHits + data.psMisses + data.psEvictions;
	var hitsPercent      = (data.psHits      / totalStatus) * 100;
	var missesPercent    = (data.psMisses    / totalStatus) * 100;
	var evictionsPercent = (data.psEvictions / totalStatus) * 100;

	$graphStatusHits.width(hitsPercent + "%");
	$graphStatusMisses.width(missesPercent + "%");
	$graphStatusEvictions.width(evictionsPercent + "%");
	$graphStatusP.html("Hits: <code>"
		+ data.psHits
		+ "</code>, Misses: <code>"
		+ data.psMisses
		+ "</code>, Evictions: <code>"
		+ data.psEvictions
		+ "</code>");

	// Space
	var spaceFreePercent = (data.spaceFree / data.spaceTotal) * 100;

	$graphFreeSpace.width(spaceFreePercent + "%");
	$graphSpaceUsed.width(100 - spaceFreePercent + "%");
	$graphSpaceP.html("<code>"
		+ data.spaceFree.toFixed(2) + "</code>MB / <code>"
		+ data.spaceTotal.toFixed(2)
		+ "</code>MB (<code>"
		+ spaceFreePercent.toFixed(2)
		+ "</code>% free)"
	);

	// General information
	$infoUptimeP.html(data.uptime);
	$infoItemsP.html(number_format(data.currItems));
	$infoActionsP.html(number_format(data.cmdGet + data.cmdSet));
	$infoConnectionsP.html(number_format(data.currCons));
});

// Create a timeout to make sure we still have a connection to our server
setInterval(function() {
	if (! showSplash) {
		// Do nothing, user has closed the splash
	} else if (new Date() - pusherUpdated > 10000) {
		$splash.fadeIn(1000).find("h3").html("Connection to Memcached server lost.<br />"
			+ "<span>Click anywhere to close this screen</span>"
		);
	} else {
		$splash.fadeOut(1000);
		showSplash = true;
	}
}, 5000);

// Allow users to close the splash screen to inspect the application
$splash.bind("click", function() {
	$splash.fadeOut(1000);
	showSplash = false;
	return false;
});