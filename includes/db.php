<?php ob_start();
	
	// $db["DB_HOST"] = "localhost";
	// $db["DB_USER"] = "root";
	// $db["DB_PASS"] = "";
	// $db["DB_NAME"] = "cms";

	// foreach ($db as $key => $value) {
	// 	define($key,$value);
	// }

	$connection = mysqli_connect("localhost","root","","cms");
?>