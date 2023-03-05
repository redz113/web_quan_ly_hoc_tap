<?php 
	include "Connect.php";

	$idCD = $_GET['idCD'];
	$idKH = $_SESSION['idKH'];

	xoaBTCD($idCD);                                 //Xóa Bài Tập của Chủ đề     	 125 - function.php
	xoa("tb_chu_de", $idCD);                        //118 - function.php

	delete_success();                  // 137 - function.php

	header("refresh: 0.3; url =ChuDeKhoaHoc.php?idKH=$idKH");
?>
