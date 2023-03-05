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
		$idHL=$_GET['idHL'];
		$folderHL='';
		$tenFileHL='';
		$tenHL='';
		$kq='';
		if (isset($_POST['saveHL'])) {
			$fileHL=$_FILES['file_hoc_lieu'];
			$tenHL=$_POST['tenHL'];
			if (empty($tenHL)) {
				$kq.='Tên học liệu? <br>';
			}
			if (empty($fileHL['name'])) {
				$kq.='File học liệu?';
			}
			if (isset($kq)&&!empty($kq)) {
				echo "<div class='check check_error'>$kq</div>";
			}else{
				$extension=strtolower(pathinfo($fileHL['name'], PATHINFO_EXTENSION));
				if ($extension=="pdf") {
					$tenFileHL = $fileHL['name'];
					move_uploaded_file($fileHL['tmp_name'], $tenFileHL);
					$sql = "UPDATE tb_hoc_lieu SET ten_hoc_lieu = '$tenHL', ten_file_hoc_lieu = '$tenFileHL' WHERE id = ".$idHL."";
          mysqli_query($conn, $sql);
					echo "<div class='check'>Sửa học liệu thành công!</div>";
				}
			}
		}
	?>
	<div class="d-flex justify-content-center mt-3">
        <form action="" method="POST" enctype="multipart/form-data" class="w-50">
            <h3>Sửa học liệu</h3>
            <div class="mb-3">
              <label for="tenHL" class="form-label">Tên học liệu</label>
              <input type="text" class="form-control" id="tenCD" name="tenHL" placeholder="Nhập tên học liệu" value="<?php if (isset($tenHL)) {
                  echo $tenHL;
              } ?>">
              <label for="file_hoc_lieu" class="form-label">Chọn file học liệu</label>
              <input type="file" class="form-control" id="file_hoc_lieu" name="file_hoc_lieu">
            </div>
            <input type="submit" class="btn btn-success" name="saveHL" value="Lưu">
            <a href="TaiLieuMonHoc.php?idKH=<?php echo $idKH; ?>" class="btn btn-success">Trở lại</a>

        </form>
    </div>

</body>
</html>