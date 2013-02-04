// Setup our Pusher information
var pusher        = new Pusher(pusherApiKey);
var pusherChannel = pusher.subscribe(pusherChannel);

// This function is called when we receive a push event
pusherChannel.bind(pusherEvent, function(data) {
	// First, set the graph
	window.plot.setData([{
		data:       getData(data.hitsPerSecond),
		color:      "#FFF",
		shadowSize: 2
	}]);
	window.plot.draw();

	// Now let's update the stats
	// Left column
	document.getElementById("stat-current-items").innerHTML     = data.currItems;
	document.getElementById("stat-reads").innerHTML             = data.cmdGet;
	document.getElementById("stat-read-hits").innerHTML         = data.getHits;
	document.getElementById("stat-read-misses").innerHTML       = data.getMisses;
	document.getElementById("stat-sets").innerHTML              = data.cmdSet;
	document.getElementById("stat-evictions").innerHTML         = data.evictions;
	// Right column
	document.getElementById("stat-uptime").innerHTML            = data.uptime;
	document.getElementById("stat-process-id").innerHTML        = data.processId;
	document.getElementById("stat-cur-connections").innerHTML   = data.currConnections;
	document.getElementById("stat-total-connections").innerHTML = data.totalConnections;
});