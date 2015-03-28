var express = require('express')
var app = express();
var http = require('http').Server(app);
var fs = require('fs');
var io = require('socket.io')(http);

app.get('/', function(request, response){
	response.sendFile(__dirname + '/public/index.html');
});
app.use(express.static('public'));


io.on('connection', function(socket){
	console.log('a user has connected');

	socket.on('chat message', function(msg){
		console.log('message: ' + msg);
		io.emit('chat message', msg);
	});

	socket.on('disconnect', function(){
    	console.log('user disconnected');
 	});
});


http.listen(3000, function(){
	console.log('listening on port 3000');
});

