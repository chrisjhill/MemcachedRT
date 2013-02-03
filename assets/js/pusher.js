// Setup our Pusher information
var pusher        = new Pusher(pusherApiKey);
var pusherChannel = pusher.subscribe(pusherChannel);

// This function is called when we receive a push event
pusherChannel.bind(pusherEvent, function(data) {
	window.plot.setData([{
		data:       getData(data.message),
		color:      "#FFF",
		shadowSize: 2
	}]);
	window.plot.draw();
});