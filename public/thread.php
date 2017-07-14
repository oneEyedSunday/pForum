<?php
	require_once("../includes/initialize.php");
	isset($_GET['id']) ? null : $_GET['id'] = 1;
	include("layouts/header.php");

	$thread = Threads::findById($_GET['id']);
	if(!$thread){
		echo "The thread couldn&apos;t be displayed, please try again later" ;
	}else{
		if(sizeof($thread) == 0){
			echo "This topic does not exist.";
		}else{
			echo "<table>";
			echo '<thead class="cent"><tr><th  colspan="2">'.$thread->title."</th></tr></thead>";
			$posts = Posts::findPostsByThread($_GET['id']);

    		
    		if(!$posts){
    			echo "The posts could not be displayed, please try again later.";
    		}else{
    			if(count($posts) == 0){
    				echo 'There are no posts on this topic yet.';
    			}else{
    				//print_r($posts);
    				foreach($posts as $p){
    					$c = new User();
    					$c = User::findById($p->postby);
    					echo '<tr>';
                        echo '<td class="rightpart">';
                        echo "<img src=' $c->avatar_path'>" ;
                            echo $c->username . '&nbsp;' . ' at ' .$p->date;
                        echo '</td>';
                        echo '<td class="leftpart">';
                            echo $p->content;
                        echo '</td>';
                    echo '</tr>';
    				}
    			}
    		}
		}

}
		?>
	</table>

	<!-- lock reply to guests -->
    <p><span class="replyheader">Reply:</span>
    <form method="post" action="reply.php?id=<?php echo $_GET["id"]; ?>" ><!-- make multimedia -->
		    <textarea name="content"></textarea><br/>
		    <input id="submitthread"class="btn btn-block btn-primary" type="submit" value="Submit reply" />
		</form></p>
<?php
include("layouts/footer.php");
?>