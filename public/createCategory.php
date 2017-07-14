<?php
	require_once("../includes/initialize.php");
	if(!$session->isloggedIn()){
		$session->setMessage("You need to be signed in to create a category!");
		redirect_to("index.php");
	}
	require_once("layouts/header.php");
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		?>
		<form method="post" action="">
	        <p>Category name: <input type="text" name="catname" /></p> 
	        <p>Category description:</p> <textarea name="catdescription"/></textarea><br/>
	        <input type="submit" value="Add category" />
     	</form>

		<?php
	}
	elseif($_SERVER["REQUEST_METHOD"] == "POST"){
		$nc = new Categories();
		$nc->categoryname = $database->escapeValue($_POST["catname"]);
		$nc->categorydescription = $database->escapeValue($_POST["catdescription"]);
		$errcheck = $nc->save();
		if($errcheck){
			$session->setMessage("Category created successfully.");
			redirect_to("index.php");
		}
		else{
			$session->setMessage("Couldnt create category.");
			redirect_to("index.php");
		}
	}
	else{
			$session->setMessage("Caled file directly!");
			redirect_to("index.php");
		}
	require_once("layouts/footer.php");
?>