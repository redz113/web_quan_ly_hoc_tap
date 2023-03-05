<?php 
	include "Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Thêm Bài Luyện Tập</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/cssX/check.css">
</head>
<body>
    <main style="min-height: 90vh; max-width: 100%;">

    	<?php 
            include "navbar.php";
        ?>
        <div style="height: 86px;"></div>

        <?php
            $idKH = $_SESSION['idKH'];
           
            if (isset($_POST['saveBT'])) {
                $tenBL = trim($_POST['tenBL']);
                $ngayDong = trim($_POST['ngayDong']);

                if (empty($tenBL) || empty($ngayDong)) {
                    echo "<div class='check check_error'>Cần nhập đầy đủ thông tin</div>";
                }else{
                    $sql = "INSERT INTO tb_luyen_tap(id_khoa_hoc, ten, ngay_dong) VALUES($idKH, '$tenBL', '$ngayDong')";
                    mysqli_query($conn, $sql);
                    echo "<div class='check'>Thêm thành công</div>";
                    // header("refresh: 0.5; url=ThemCauHoi.php?id");
                }
            }

        ?>

    	<div class="d-flex justify-content-center mt-3">
            <form action="" method="POST" enctype="multipart/form-data" class="w-50">
                <h3>Thêm bài luyện tập</h3>
                <div class="mb-3">
                  <label for="tenBL" class="form-label">Tên bài luyện tập</label>
                  <input type="text" class="form-control" id="tenBL" name="tenBL" placeholder="Nhập tên ở đây" value="<?php if (isset($tenBL)) {
                      echo $tenBL;
                  } ?>">
                </div>
            
                <div class="mb-3">
                  <label for="ngayDong" class="form-label">Ngày đóng</label>
                  <input type="datetime-local" class="form-control" id="ngayDong" name="ngayDong" placeholder="Nhập hạn nộp" value="<?php if (isset($ngayDong)) {
                      echo $ngayDong;
                  } ?>">
                </div>

                <input type="submit" class="btn btn-success" name="saveBT" value="Lưu">
                <a href="LuyenTap.php" class="btn btn-success" >Trở lại</a>

            </form>
        </div>
	</main>
    <?php include "footer.php"; ?>
</body>
</html>


