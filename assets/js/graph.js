google.load("visualization", "1", { packages: ["corechart"] });
google.setOnLoadCallback(function() {
	// Google Charts has loaded, let's set some global variables.
	// .. We do this here and not in the drawChart function so it
	// .. isn't executed every time!

	// These are the options for the Google Area Chart
	window.options = {
		backgroundColor:    { fill: "#E67373" },
		colors:             [ "#FFF", "#D61414" ],
		areaOpacity:        0.2,
		legend:             { position: "none" },
		chartArea:          { left: 0, top: 0, width: "100%", height: "100%" },
		lineWidth:          1,
		fontSize:           10,
		vAxis: {
			minValue:       0,
			maxValue:       window.maxMemcachedHitsPerSecond,
			textStyle:      { color: "#F6CBCB" },
			textPosition:   "in",
			gridlines:      { color: "#F0AEAE", count: 6 },
			minorGridlines: { color: "#EA8989", count: 1 },
			baselineColor:  "#E67373",
		},
	};

	// Allow the graph to animate?
	if (window.graphEnableAnimations) {
		window.options['animation'] = { duration: 1000, easing: "inAndOut" };
	}

	// This is the reference to the DOM element
	window.chart = new google.visualization.AreaChart(
		document.getElementById("memcached-graph-live")
	);
});

// Draw the Google Chart
// This is called from within the pusher.js file
function drawChart() {
	window.chart.draw(
		google.visualization.arrayToDataTable(window.data),
		window.options
	);
}

// Data holds all of the points that we need to log
// @todo Get this from MySQL sometime in the fure.
var data = [];
for (i = 0; i <= window.seconds; i++) { data.push([ "void", 100, 0 ]); }

// Update our data array with the new data received from the push event
function getData(psActions, psEvictions) {
	// Take the oldest point off..
	data = data.slice(1);

	// .. and add in the new data
	window.data.push([
		new Date().toUTCString(),
		parseInt(psActions),
		parseInt(psEvictions)
	]);
}