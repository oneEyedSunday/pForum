<?php
	require_once("../includes/initialize.php");
	if(!$session->isloggedIn()){
		$session->setMessage("You need to be signed in to create a thread!");
		redirect_to("index.php");
	}
	require_once("layouts/header.php");
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		$cc = Categories::findAll(); 
        if(!$cc){
            $session->setMessage('Error while selecting from database. Please try again later.');
            redirect_to("index.php");
        }
        else{
            if(sizeof($cc) == 0){
            	/* When Admin table created
                //there are no categories, so a topic can't be posted
                if($_SESSION['userlevel'] == admin){}
                else{}
                */
                $session->setMessage("You have not created categories yet." . 
                	'Before you can post a topic, you must create some categories.');
            }
            else{
            	?>
            	<form method="post" action="">
                   <p>Subject: <input type="text" name="title" /></p>
                   <p>Category:
                    <select name="category">';
                <?php
                    foreach($cc as $cat){
                        echo '<option value="' . $cat->id . '">' . $cat->categoryname . '</option>';
                    }
                ?>
                	</select>
                   </p> 
                     
                   <p>Message:</p> <textarea name="content" /></textarea><br/>
                    <input type="submit" value="Create topic" />
                 </form>
             <?php
            }
        }
		?>
		<!-- <form method="post" action="">
	        <p>Category name: <input type="text" name="catname" /></p> 
	        <p>Category description:</p> <textarea name="catdescription"/></textarea><br/>
	        <input type="submit" value="Add category" />
     	</form> -->

		<?php
	}
	elseif($_SERVER["REQUEST_METHOD"] == "POST"){

        //start the transaction
        $q = "BEGIN WORK;";
        $database->query($q);
        $s = "INSERT INTO  threads(title,date,category,owner) ";
        $s.= " VALUES('" . $database->escapeValue($_POST['title']);
        $s.= "',NOW()," . $database->escapeValue($_POST['category']);
        $s.= ", " . $session->userId() . ")";
                      
        $result = $database->query($s);
        if(!$result){
                $session->setMessage('An error occured while inserting your data. Please try again later.');
                $sql = "ROLLBACK;";
                $result = $database->query($sql);
            }
            else{
                $threadId = $database->insertId();                 
                // $s = "INSERT INTO
                //             posts(content,
                //                   date,
                //                   thread,
                //                   by)
                //         VALUES
                //             (" . $database->escapeValue($_POST['content']) . ",
                //                   NOW(),
                //                   " . $threadId . ",
                //                   " . $session->userId() . "
                //             )";
                $result = Posts::make($threadId,$session->userId(), $_POST['content']);
                //make($thread,$by, $content)
               // $result = $database->query($s);
                 
                if(!$result){
                    //something went wrong, display the error
                    $session->setMessage('An error occured while inserting your post. Please try again later.');
                    $sql = "ROLLBACK;";
                    $database->query($sql);
                }
                else{
                    $sql = "COMMIT;";
                    $database->query($sql);
                    $session->setMessage("Thread created successfully");
                    redirect_to("thread.php?id=".$threadId);              
                }
        }
	}
	else{
			$session->setMessage("Caled file directly!");
		}
	require_once("layouts/footer.php");
?>