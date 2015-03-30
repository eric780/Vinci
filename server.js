var express = require('express')
var app = express();
var http = require('http').Server(app);
var fs = require('fs');
var io = require('socket.io')(http);


var people = {};

app.get('/', function(request, response){
	response.sendFile(__dirname + '/public/index.html');
});
app.use(express.static('public'));


io.on('connection', function(socket){
	console.log('a user has connected');

	//message sent from a user
	/*data:{
		sender:
		contents:
	}
	*/
	socket.on('chat message', function(data){
		console.log('message from ' + data.sender + ' at ' + JSON.stringify(data.coord) + ' : ' + data.contents);

		//broadcast message to everyone but the user who sent it
		socket.broadcast.emit('chat message', {sender: data.sender, contents:data.contents});
	});

	socket.on('disconnect', function(){
    	console.log('user disconnected');
 	});
});

http.listen(process.env.PORT || 3000, function(){
	console.log('listening on port 3000');
});


