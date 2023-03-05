<?php 
	include "Connect.php";

	$idBT = $_GET['idBT'];
	$idKH = $_SESSION['idKH'];

	$sql = "SELECT ten_file_bai_tap, ten_file_tai_lieu FROM tb_bai_tap WHERE id = $idBT";
	$query = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($query);

	if (!empty($row['ten_file_bai_tap']) && file_exists($folderBT .$row['ten_file_bai_tap'])) {
		unlink($folderBT .$row['ten_file_bai_tap']);
	}

	if (!empty($row['ten_file_tai_lieu']) && file_exists($folderBT .$row['ten_file_tai_lieu'])) {
		unlink($folderBT .$row['ten_file_tai_lieu']);
	}

	xoaBNBT($idBT);                    //Xóa Bài Nộp      150

	xoa("tb_bai_tap", $idBT);                        //118 - function.php

	delete_success();                  // 137 - function.php           thông báo xóa thành công

	header("refresh: 0.3; url =ChuDeKhoaHoc.php?idKH=$idKH");
?>
