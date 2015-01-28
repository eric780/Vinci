<?php

$returner = array();
$file = 'send.txt';
$current = file_get_contents($file);
$temp = explode('mes:',$current);
for ($index=0;$index < count($temp);$index++){
	$temp2 = $temp[$index];
	$temp3 = explode('~',$temp2);
	if ($temp3[1] != null){
		$arr = array('id' => $temp3[0],'message' => $temp3[1],'longitude' => $temp3[2], 'latitude' => $temp3[3], 'name' => $temp3[4]);
		$returner[] = $arr;
	}
	
}
//header('Content-Type: application/json');
/*$t = time();
$t2=$t + 5;
while ($t < $t2){
	$t = time();
}*/

/*if (count($returner)>200){                //clears temp storage file (txt)
	file_put_contents($file,"");
}*/
echo json_encode($returner);
return;


?>