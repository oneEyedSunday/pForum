<?php
	require_once('constants.php');
	$conn = mysqli_connect($server, $username,  $password, $database); 
	if(!$conn)
	{
	    exit('Error: could not establish database connection');
	}

?>