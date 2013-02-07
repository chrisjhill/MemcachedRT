google.load("visualization", "1", {packages:["corechart"]});

function drawChartHps() {
	var data = google.visualization.arrayToDataTable(window.dataHps);

	var options =  {
		legend:    { position: "none" },
		chartArea: { left: 0, top: 0, width: "100%", height: "100%" },
		lineWidth: 1,
		fontSize:  10,
		vAxis: {
			minValue:       0,
			maxValue:       window.maxMemcachedHitsPerSecond,
			textPosition:   "in",
			gridlines:      { count: 6 },
			minorGridlines: { color: "#EEE", count: 1 }
		},
	};

	var chart = new google.visualization.AreaChart(
		document.getElementById("memcached-graph-hps")
	);

	chart.draw(data, options);
}

// Data holds all of the points that we need to log
// @todo Get this from MySQL sometime in the fure.
var dataHps = [];
for (i = 0; i <= window.seconds; i++) {
	dataHps.push([ "void", 100 ]);
}

// Update our data array with the new data received from the push event
function getDataHps(hitsPerSecond) {
	// Take the oldest point off and push the new one
	dataHps = dataHps.slice(1);
	window.dataHps.push([
		new Date().getTime().toString(),
		parseInt(hitsPerSecond)
	]);
}