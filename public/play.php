<?php
	echo date(time());
	echo "<hr/>";
	echo "file:" . date(time()) . ".jpg" . "<br/>";
	$d = "1499936166image/jpeg";
	echo $d . "<hr/>";
	$f = str_replace($d, "image", ".");
	echo $f;
	echo __DIR__ . "<br/>" . basename(__DIR__);
	echo __FILE__ . "<br/>" . basename(__FILE__);
	echo "<br/>" . basename($d);
?>