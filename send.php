<?php
/*if (!empty($_POST[user_id])){
	echo "POST WORKS!!";
}
else
	echo "NOOOOOO!!";*/

//$data = json_decode(file_get_contents('php://input'), true);
//echo $data['user_id'];




//print "DATA: <pre>";
//var_dump($data);
//var_dump($_POST);

$user_id = $_POST['user_id'];
echo $user_id;
$longitude = $_POST['longitude'];
echo $longitude;
$latitude = $_POST['latitude'];
$message = $_POST['message'];
echo $message;
$name = $_POST['name'];
echo $name;

//fwrite($fp,'mes:' . $user_id . '~' . $message . '~' . $longitude . '~' . $latitude);

//fclose($fp);

$file = 'send.txt';
$data1 = file_get_contents($file);
//$fp = fopen("send.txt","w+");
$data2 = 'mes:' . $user_id . '~' . $message . '~' . $longitude . '~' . $latitude . '~' . $name;
$data3 = $data1 . $data2;
$length = file_put_contents($file,$data3); 
//fwrite($fp,'mes:' . $user_id . '~' . $message . '~' . $longitude . '~' . $latitude);
//fclose($fp);
if($length > 0){
	$success = array('send' => 'success');
	echo json_encode($success);
	return;
}else{
	//$failure = array('send' => 'failure');
	$failure = array('user_id' => $user_id, 'message' => $message);
	echo json_encode($failure);
	return;
  }
?>