google.load("visualization", "1", {packages:["corechart"]});

function drawChart(freeSpace, usedSpace) {
	var data = google.visualization.arrayToDataTable([
		['Status', 'Percent'],
		['Used space', parseInt(usedSpace)],
		['Free space', parseInt(freeSpace)]
	]);

	var options = {
		is3D:      true,
		legend:    {position: 'none'},
		chartArea: { left: 0, top: 0 },
		chartArea: { left: 0, top: 0, width: "100%", height: "100%"}
	};

	var chart = new google.visualization.PieChart(
		document.getElementById('memcached-graph-space')
	);

	chart.draw(data, options);
}