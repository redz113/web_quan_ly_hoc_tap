<?php
	include "Connect.php";

	$tenTK = $_GET['tenTK'];
	$idRole = $_GET['idRole'];

	if(xoaTK("tb_tai_khoan", $tenTK, $idRole)==false){					//145 - function.php
		echo 
		"
		<script type='text/javascript'>
			alert('Bạn không thể xóa tài khoản admin');
		</script>
		";
	}else{
	echo 
	"
		<script type='text/javascript'>
			alert('Xóa thành công!!!');
		</script>
	";
	}
	header("refresh: 0.3; url =QuanLyTaiKhoan.php");
?>