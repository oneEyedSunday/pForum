<?php 
	require_once("../includes/initialize.php");
	isset($_GET['id']) ? null : $_GET['id'] = 1;
	include("layouts/header.php"); 

	$category = Categories::findById($_GET['id']);
	if(!$category){
		echo "The category couldnot be displayed, please try again later" ; //. mysqli_error($database->conn);
	}else{
			$o = "<h3>Topics in '";
			$o .= $category->categoryname . "'category</h3>";
			echo $o;

		//find topics/threads in category
		$topicSet = Threads::findThreadsByCat($category->id);
		if(!$topicSet){
			echo 'The topics could not be displayed, please try again later.';
		}else{
			if(count($topicSet) == 0){
				echo 'There are no topics in this category yet.';
			}else{
				$o = '<table border="1"><tr><th>Topic</th><th>Created at</th></tr>';
				foreach($topicSet as $t){
					$o .= '<tr><td class="leftpart"><h3><a href="thread.php?id=';
					$o .= $t->id . '">' . $t->title . '</a><h3>';
					$o .= '</td><td class="rightpart">';
                    $o .= date('d-m-Y h:i:s A T', strtotime($t->date));
                    $o .= '</td></tr>';
				}
				$o .= "</table>";
				$session->setMessage("yah");
				echo $o;
				
			}
		}
	}


	include("layouts/footer.php");
?>