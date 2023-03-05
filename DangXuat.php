<?php 
	session_start();
	unset($_SESSION['user']);
	// unset($_SESSION['idKH']);
	// unset($_SESSION['idBT']);
	session_destroy();
	header("location: DangNhap.php");
?>