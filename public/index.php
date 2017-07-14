<?php
	require_once("../includes/initialize.php");
	include("layouts/header.php");

?>
<div id="sessionmsg">

	<?php
		if(($session->getMessage())){
			echo "<p>" . $session->getMessage() . "</p>";
		}
	?>
</div>
<h3>Forum</h3>
<table>
	<tr><th class = "leftpart">Category</th>
	<th class= "rightpart">Last Topic</th></tr>
	<?php
	//$c = new Categories();
	$allcats = Categories::findAll();
	foreach($allcats as $cat){
		//print_r($cat);
		echo "<tr>";
		$susid = $cat->id;
 		echo "<td class='leftpart'>" . "<h3><a href='category.php?id={$susid}'>" . $cat->categoryname . '</a></h3>' . $cat->categorydescription. "</td>";
 		echo "<td class='rightpart'>" . $cat->findLastTopic(). "</td>";
 		echo "</tr>";
	}

	?>



</table>




<?php include("layouts/footer.php"); ?>