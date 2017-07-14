<?php  
//echo __DIR__;
//require_once("../../includes/session.php"); ?>
<html>
	<head>
		<title>OneEyed forum</title>
		<link rel="stylesheet" href="stylesheets/auth.css" type="text/css">
	</head>


	<body>
		<h1>OneEyed Forum</h1>
		<div id="wrapper">
			<div id="menu">
				<a class="item" href="index.php"><?php isset($signinpage) ? null : $signinpage = false; if($signinpage){echo "Back Home";}else{echo "Home";}?></a>
				<?php
				if($session->isloggedIn()){
					echo "
					-<a class=\"item\" href=\"createthread.php\">Create a Thread</a>-
					<a class=\"item\" href=\"createcategory.php\">Create a Category</a>
					";
				}
				?>
				<div id="userbar"><?php
				
				if(!$signinpage){

					if(!$session->isloggedIn()){
						$o = 'Hello guest, ';
						$o .= "<p>Have an account? Yes!<a href=\"signin.php\">Sign in</a></p> ";
						$o .= 'No! <a href="signup.php">create an account here!</a>';
						echo $o;
					}else {
						$o = 'Hello ' . $session->userName() . ',';
						$o .= "<img src='". $_SESSION['avatar_path'] ."'>";
						$o .= 'Not you? <a href="signout.php">Sign out</a>';
						echo $o;

					}
				}
    			?>
				</div>
				</div>
			<div id="content"> 
