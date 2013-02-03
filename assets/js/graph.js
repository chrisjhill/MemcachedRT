// Data holds all of the points that we need to log
var data = [];

// Get the initial data
// @todo Will be nice to load this from the database once we get round to it
function getInitialData() {
	for (var i = 0; i <seconds; ++i) {
		data.push([i, 10]);
	}
	return data;
}

// Update our data array with the new data received from the push event
function getData(hitsPerSecond) {
	// Take the oldest point off and push the new one
	data = data.slice(1);
	data.push([299, hitsPerSecond]);

	// Flot is a bit annoying here in that we need to "flatten" the data into
	// .. 1, 2, 3, etc. instead of allowing a naturally increasing number.
	var dataRefresh = [];
	for (var i = 0; i < data.length; ++i) {
		dataRefresh.push([i, data[i][1]])
	}

	// Set the data to new the refreshed data list and return
	data = dataRefresh;
	return data;
}

// Not plot the graph
var plot = $.plot(
	// The DOM element we want to place the grid
	$("#memcached-graph"),

	// Series data
	[{
		data:       getInitialData(),
		color:      "#FFF",
		shadowSize: 2
	}],

	// And any options to give the graph
	options = {
		// Make the lines a little nicer, thin line with an opaque fill
		series: {
			lines: {
				lineWidth: 1,
				fill:      true,
				fillColor: "rgba(255, 255, 255, 0.6)"
			},
		},

		// The "background" of the chart
		grid: {
			borderWidth:     1,
			minBorderMargin: 10,
			labelMargin:     4,
			backgroundColor: {
				colors: [
					// These are the actual background colours
					// It goes in a top-to-bottom direction
					"rgba(255, 255, 0, 0.6)",
					"rgba(  0, 136, 0, 0.6)"
				]
			},
		},

		// The min/max values for the data
		yaxis: {
			min: 0,
			max: maxMemcachedHitsPerSecond
		}
	}
);