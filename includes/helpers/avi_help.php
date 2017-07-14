<?php
	//echo dirname("/includes/helpers/initialize.php");
	//require_once("/includes/helpers/initialize.php");
	

	function avi($avatar_path){
		global $database;
		global $session;
		$newuser = new User();
		$newuser->firstName = trim($database->escapeValue($_POST["userfirstname"]));
		$newuser->lastName = trim($database->escapeValue($_POST["userlastname"]));
		$newuser->username = trim($database->escapeValue($_POST["username"]));
		$newuser->password = $database->escapeValue($_POST["userpass"]);
		$newuser->email    = trim($database->escapeValue($_POST["useremail"]));
		$newuser->avatar_path = $avatar_path;
		$check = $newuser->save();
		if($check == false){
			$e = 'Something went wrong while signing up. Please try again later.';
			$session->setMessage($e);
		} else {
			$session->login($newuser);
			$e = 'Welcome, '.$session->userName();
			$session->setMessage($e);
			redirect_to("index.php");
		}

	}

	function process_signup(){
		global $database;
		global $session;
		isset($_POST['avatar']) ? null : $_POST['avatar'] = "default.png";
		if($_POST['avatar'] != "default.png"){
			$avatar_path = $database->escapeValue("images\\".get_random_avi_name() .".".end((explode(".", $_FILES['avatar']['name']))));
			//$pathparts = pathinfo($_FILES['avatar']['name']);
			//$extesn = $pathparts['extension'];
			//pathinfo($filename,PATHINFO_EXTENSION)
			if(preg_match("!image!", $_FILES['avatar']['type'])){
				if(copy($_FILES['avatar']['tmp_name'], $avatar_path)){
					avi($avatar_path);
                    $session->setMessage($_POST['avatar']);
                }
                  else {
                      $session->setMessage("File upload failed!");
                    }
                }
                else {
                        $session->setMessage("Please only upload GIF, JPG or PNG images!");
                      }
                }else{
                      $avatar_path = "images\\default.png";
                      avi($avatar_path);
                  }

	}

	function get_random_avi_name(){
		return date(time());
	 }

?>