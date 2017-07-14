<?php
	$host = "localhost";
	$user = "homestead";
	$pass = "secret";
	$db = "pforum";
	$conn = mysqli_connect($host,$user,$pass,$db);
	if(isset($_POST["user_name"])){
		$name = $_POST["user_name"];
		$checkdata = "select * from users where username = '$name' ";
		$query = mysqli_query($conn,$checkdata);
		// $result = mysqli_query($this->conn, $sql);
		if(mysqli_num_rows($query) > 0){
			echo "User Name Already exists";
		}else{
			echo "OK";
		}
		exit();
	}

	if(isset($_POST["user_email"])){
		$emailid = $_POST["user_email"];
		$checkdata = "select * from users where email = '$emailid' ";
		$query = mysqli_query($conn,$checkdata);
		if(mysqli_num_rows($query) > 0){
			echo "Email Already exists";
		}else{
			echo "OK";
		}
		exit();
	}
