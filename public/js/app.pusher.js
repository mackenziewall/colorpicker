
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('0c38ef7d30a8ee3a1055', {
  encrypted: true
});

var channel = pusher.subscribe('test_channel');
channel.bind('my_event', function(data) {
  console.log(data.message);
});