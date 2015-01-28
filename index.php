<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<!DOCTYPE html>
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Anon Chat</title>
<link type="text/css" rel="stylesheet" href="stylesheet.css" />
<link href="bootstrap 3.1.1/css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="jquery.js"></script>
<script src="bootstrap 3.1.1/js/bootstrap.min.js"></script>

</head>

<body>
	<div id="wrapper">
    	<h1>Vinchy</h1>
    	<form>Now chatting as <input type="text" value="Anonymous" id="nickname"></form>
    	<div id="chatbox"><b>Anonymous Local Chat, say Hello!</b><br /></div>
        <form id="message" method="POST" action='send.php'>
            <input type="button" id="sendmsg" value="Submit"/>
            <input type="text" id="usermsg" autofocus = "autofocus" size="100" />
            <!--<button id='sendmsg' name='sendmsg' />-->
        </form>
    </div>


<script type="text/javascript">
	$(document).ready(function(){
		var user_chat_index;
		

		var x = navigator.geolocation;               //get geolocation
		x.getCurrentPosition(success, failure);
		var mylat;
		var mylong;
		function success(position){
			mylat = position.coords.latitude;
			mylong = position.coords.longitude;
		}
		function failure(){
			alert("Geolocation not enabled");
		}
		
		var myid;
		$.ajax({                                    //obtain unique user id
			type: "GET",
			url: "getID.php",
			success: setID
			}
		);
		
		function setID(response){
			myid = $.parseJSON(response).id;
			user_chat_index = $.parseJSON(response).chat_index;
		}


		$('#usermsg').keypress(function(e){         //makes enter button = click send
			if(e.which==13){
			e.preventDefault();
			$('#sendmsg').click();}});


		function updateChat(){
			console.log("HELLO2");
			$.ajax({
				type:"GET",
				url:"receiver.php",
				dataType:"json",
				success: function(data){
					//endindex = $.parseJSON(data).length;
					if(user_chat_index > data.length)
						user_chat_index = 0;
					console.log(user_chat_index);
					console.log(data.length);
					for(var i = user_chat_index; i<data.length; i++){
						if(data[i].id == myid && data[i].name == "Anonymous")
							$("#chatbox").append("You: " + data[i].message);
						else if(data[i].id == myid && data[i].name != "Anonymous")
							$("#chatbox").append(data[i].name + ": " + data[i].message);
						else
							$("#chatbox").append("Anonymous " + data[i].id + ": " + data[i].message);
						$("#chatbox").append("<br />");
					}
					document.getElementById('chatbox').scrollTop = document.getElementById('chatbox').scrollHeight;
					user_chat_index = data.length;
				}
			})
		}

		setInterval(function(){
			console.log("HELLO");
			updateChat();
		},
		1000);
		

		$('#sendmsg').click(function(){                  //submitting on enter press or button click
			var inputstring = $('#usermsg').val();
			var myname = $('#nickname').val();
			$.ajax({
				type: "POST",
				url: "send.php",
				data: {'user_id': myid, 'longitude': mylong, 'latitude': mylat, 'message': inputstring, 'name': myname},
				success: function(){
					$('#usermsg').val("");
					//$('#chatbox').append("You: " + inputstring);
					//$('#chatbox').append('<br />');
				}
			});
			updateChat();

		});
	});
</script>


</body>
</html>
