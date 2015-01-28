<?php

$returner = array();
$file = 'send.txt';
$current = file_get_contents($file);
$temp = explode('mes:',$current);
for ($index=0;$index < count($temp);$index++){
	$temp2 = $temp[$index];
	$temp3 = explode('~',$temp2);
	if ($temp3[1] != null){
		$arr = array('id' => $temp3[0],'message' => $temp3[1],'longitude' => $temp3[2], 'latitude' => $temp3[3]);
		$returner[] = $arr;
	}	
}

$file = 'id.txt';
$current = file_get_contents($file);
$int_id = intval($current);
$int_id2 = $int_id + 1;
file_put_contents($file,"");
$length = file_put_contents($file,$int_id2 . '');
if($length > 0){
	$success = array('id' => $int_id2, 'chat_index' => count($returner));
	echo json_encode($success);
	return;
}else{
	$failure = array('id' => $int_id2, 'chat_index' => count($returner));
	echo json_encode($failure);
	return;
  }
?>