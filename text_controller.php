<?php
	session_start();
    $current_path = $_SERVER["REQUEST_URI"];;
    $action = '';
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && strpos($current_path, 'send') > 0)
        $action = 'send';
    if(($_SERVER['REQUEST_METHOD'] == 'GET') && strpos($current_path, 'receiver') > 0)
    	$action = 'receiver';
	if(($_SERVER['REQUEST_METHOD'] == 'GET') && strpos($current_path, 'getID') > 0)
    	$action = 'getID';
    $action();

	function getID(){
		if (!isset($_SESSION['id'])){
			$_SESSION['id'] = 1;
		}
		else{
			$temp = $_SESSION['id'];
			$temp = $temp + 1;
			$_SESSION['id'] = $temp;
		}
		$array = array('id' => $_SESSION['id']);
		header('Content-Type: application/json');
		echo json_encode($array);
        return;
	}
	
	function send(){
		$user_id = $_POST['user_id'];
		$longitude = $_POST['longitude'];
		$latitude = $_POST['latitude'];
		$message = $_POST['message'];
		$fp = fopen("send.txt","wb");
		fwrite($fp,'mes:' . $user_id . '~' . $message . '~' . $longitude . '~' . $latitude);
		fclose($fp);
		if($message){
			$success = array('send' => 'success');
			echo json_encode($success);
			return;
		}else{
			$failure = array('send' => 'failure');
			echo json_encode($failure);
			return;
		  }
	}
    function receiver() {
		$returner = array();
		$file = 'send.txt';
		$current = file_get_contents($file);
		$temp = explode('mes:',$current);
		for ($index=0;$index < count($temp);$index++){
			$temp2 = $temp[$index];
			$temp3 = explode('~',$temp2);
			$arr = array('id' => $temp3[0],'message' => $temp3[1],'longitude' => $temp3[2], 'latitude' => $temp3[3]);
			$returner[] = $arr;
		}
		header('Content-Type: application/json');
		echo json_encode($returner);
		file_put_contents($file,"");
        return;
        /*$status_string = '';
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        if (empty($email)) {
            $status_string = 'No email provided';
            set_json_header();
            $arr = array('string' => $status_string, 'success' => 0);
            echo json_encode($arr);
            return;
        }
        if (strpos($email, '@') < 0)    // No full email
            $email = $email . '@artzoco.com';
        else {
            if (strpos($email, '@artzoco.com') < 0) {  // Not ArtZoco email
                $status_string = 'Must use ArtZoco email';
                set_json_header();
                $arr = array('string' => $status_string, 'success' => 0);
                echo json_encode($arr);
                return;
            }
        }
        if (empty($pwd)) {  // No password
            $status_string = 'No password provided';
            set_json_header();
            $arr = array('string' => $status_string, 'success' => 0);
            echo json_encode($arr);
            return;
        }

        $u = User::find_by_email($email);
        if ($u && $u -> web_login($pwd, false)) {   // User exists and logged in
            $status_string = 'Login success';
            setcookie('admin_remember', $u -> remember_me, time() + 60*60*24*7);
            set_json_header();
            $arr = array('string' => $status_string, 'success' => 1);
            echo json_encode($arr);
            return;
        }
        else {  // Error logging in with credentials
            $status_string = 'Could not login with email and password';
            set_json_header();
            $arr = array('string' => $status_string, 'success' => 0);
            echo json_encode($arr);
            return;
        }*/
    }
	
	/*function login_mobile(){
		$email = $_POST['email'];
		$failure = array('login' => 'fail');
		if(empty($email)){
			echo json_encode($failure);
			return;
		}
		$u = User::find_by_email($email);
		if ($u){
            //$remember_me = $u -> confirm_mobile_login($_POST['password'])
            $remember_me = md5(rand(0,1000));
			if(true){
                $s = Seller::find_by_user_id($u -> id);
			  if($s){
                $success = array('login' => 'success', 'sID' => $s -> id, 'remember_me' => $remember_me);
				echo json_encode($success);
                return;
			  }else{
				echo json_encode($failure);
                return;
			  }
			}else{
				echo json_encode($failure);
				return;
			}
		}else {
  	  	echo json_encode($failure);
  	  	return;
  	  }
	}*/
?>