<?php
	require_once("../includes/initialize.php");
	require_once(LIB_PATH.DS.'database.php');
	// include("layouts/header.php");

	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		//echo "Called file directly";
		$session->setMessage("Called file directly.Duhh!");
		redirect_to("index.php");
	}else{
		//signin status
		if($session->isloggedIn()){
			$reply = Posts::make($database->escapeValue($_GET['id']),$session->userId(), $database->escapeValue($_POST['content']));
			//$session->setMessage($_GET['id'] . " - " .$session->userId(). " - " . $_POST['content']);
			if(!$reply){
				$session->setMessage("Your reply has not been saved, please try again later.");
				//$session->setMessage($_GET['id'] . " - " .$session->userId(). " - " . $_POST['content']);
				redirect_to("thread.php?id=" . $_GET['id']);
			}else {
				$session->setMessage("Reply saved.");
				redirect_to("thread.php?id=" .  $_GET['id']);
			}
		}else{		
			$session->setMessage("Must sign in to comment.");
			redirect_to("index.php");
		}
	}




?>