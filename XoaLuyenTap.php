<?php 
	include 'connect.php';
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Thêm học liệu</title>
	<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/cssX/check.css">
</head>
<body>
	<?php 
		include 'navbar.php';
	?>
	<div style="height: 86px;"></div>
	<?php
		$idKH=$_SESSION['idKH'];
		$idLT=$_GET['idBL'];
		// echo $idHL;
		$sql='DELETE FROM tb_cau_hoi WHERE id_bai_luyen_tap = '.$idLT.'';
		$query=mysqli_query($conn, $sql);
		$sql='DELETE FROM tb_luyen_tap WHERE id = '.$idLT.'';
		$query=mysqli_query($conn, $sql);
		echo "<div class='check'>Xóa bài luyện tập thành công!</div>";
	?>
	<div class="d-flex justify-content-center mt-3">
        <form action="" method="POST" enctype="multipart/form-data" class="w-50">
            <a href="LuyenTap.php?idBL=<?php echo $idLT; ?>" class="btn btn-success">Trở lại</a>
        </form>
    </div>

</body>
</html>