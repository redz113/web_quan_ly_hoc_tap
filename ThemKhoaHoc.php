<?php 
	include "Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Khóa Học</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/cssX/check.css">
    <style type="text/css">
        .check{
            background: #6EE76E;
            padding: 16px;
            margin-top: 0px;
            text-align: center;
            animation: modalFadeIn 0.5s;
        }

        .check_error{
            background: pink !important;
        }

        @keyframes modalFadeIn{
            from{
                transform: translateY(-50px);
            }
            to{
                transform: translateY(0px);
            }
        }
    </style>
</head>
<body>
    <main style="min-height: 90vh; max-width: 100%;">

    	<?php 
            include "navbar.php"; 
        ?>

    	<div style="height: 86px;"></div>

        <?php 
            if (isset($_POST['saveKH'])) {
                $tenKH = trim($_POST['tenKH']);
                $file = $_FILES['img'];
                $flag = 0;

                if (!empty($file['name'])) {
                    $flag = 1;             //Tồn tại file upload
                    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $arr = ["gif", "jpg", "png", "jpeg"];
                    if (!in_array($extension, $arr)) $kq = "File ảnh bìa chỉ nhận đuôi .jpg .jpeg .png .gif";
                        else $tenFile = floor(microtime(true) * 1000) . "." .$extension;
                }

                if (empty($tenKH)) {
                    $kq = "Tên khóa học không được để trống";
                }

                if (isset($kq)) {
                    echo "<div class='check check_error'>$kq</div>";
                }else{
                    if ($flag == 0) {
                        $sql = "INSERT INTO tb_khoa_hoc(ten_khoa_hoc) VALUES('$tenKH')";
                    }elseif ($flag == 1) {
                        move_uploaded_file($file['tmp_name'], $folderKH . $tenFile);
                        $sql = "INSERT INTO tb_khoa_hoc(ten_khoa_hoc, path_img) VALUES('$tenKH', '$tenFile')";
                    }
                    mysqli_query($conn, $sql);
                    echo "<div class='check'>Thêm thành công</div>";
                }
            }
        ?>

    	<div class="d-flex justify-content-center mt-5">
        <form action="" method="POST" enctype="multipart/form-data" class="w-75">
            <h3>Thêm Khóa Học</h3>
            <div class="mb-3">
              <label for="tenKH" class="form-label">Tên khóa học</label>
              <input type="text" class="form-control" id="tenKH" name="tenKH" placeholder="Nhập tên khóa học" value="<?php if (isset($tenKH)) {
                  echo $tenKH;
              } ?>">
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Chọn ảnh nền</label>
                <input type="file" class="form-control" id="img" name="img">
            </div>
            <input type="submit" class="btn btn-success" name="saveKH" value="Lưu">
            <a class="btn btn-success" href="KhoaHoc.php">Trở lại</a>
        </form>
        </div>
	</main>
    <?php include "footer.php"; ?>
</body>
</html>


