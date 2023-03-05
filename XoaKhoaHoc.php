<?php 
	include "Connect.php";

	$idKH = $_GET['idKH'];

	$sql = "SELECT id FROM tb_chu_de WHERE id_khoa_hoc = $idKH";
	$query = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($query)) {
	 	xoaBTCD($row['id']);                            //Xóa bài tập + bài nộp Khóa học
	 	xoa("tb_chu_de", $row['0']);					//Xóa chủ đề Khóa Học
	 };


	// Xóa Học Liệu
	 xoaHL($idKH);

	//Xóa Khóa học
	$sql = "SELECT path_img FROM tb_khoa_hoc WHERE id_khoa_hoc = $idKH";
	$query = mysqli_query($conn, $sql);
	$path = mysqli_fetch_array($query) ['0'];

	if (file_exists($folderKH . $path && $path != "img_default.jpg")) {
		unlink($folderKH . $path);
	}

	$sql = "DELETE FROM tb_khoa_hoc WHERE id_khoa_hoc = $idKH";
	mysqli_query($conn, $sql);

	delete_success();                  // 137 - function.php

	header("refresh: 0.3; url =KhoaHoc.php");


	function xoaHL($idKH){
		GLOBAL $conn;

		$sql = "SELECT id, ten_file_hoc_lieu FROM tb_hoc_lieu WHERE id_khoa_hoc = '$idKH'";
		$query = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_array($query)) {
			if (file_exists($row['1'])) {
				unlink($row['1']);
			}

			$id = $row['0'];
			$sql = "DELETE FROM tb_hoc_lieu WHERE id_khoa_hoc = $id";
			mysqli_query($conn, $sql);
		}
	}
?>