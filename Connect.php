<?php  
	session_start();
	include "./function.php";
	
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "db_btl_web";

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) 
		or die("Kết nối thất bại " .mysql_connect_error());

	if (isset($conn)) {
		mysqli_query($conn, "SET NAMES 'utf8'");
	}
?>