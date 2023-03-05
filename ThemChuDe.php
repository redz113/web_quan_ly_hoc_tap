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
            $idKH = $_GET['idKH'];

            if (isset($_POST['saveCD'])) {
                $tenCD = $_POST['tenCD'];
                if (empty(trim($tenCD))) {
                    echo "<div class='check check_error'>Tên chủ đề không được để trống</div>";
                }else{
                    $sql = "INSERT INTO tb_chu_de(id_khoa_hoc, ten_chu_de) VALUES($idKH, '$tenCD')";
                    mysqli_query($conn, $sql);
                    echo "<div class='check'>Thêm thành công</div>";
                }
            }
        ?>

    	<div class="d-flex justify-content-center mt-5">
        <form action="" method="POST" class="w-75">
            <h3>Thêm chủ đề</h3>
            <div class="mb-3">
              <label for="tenCD" class="form-label">Tên chủ đề</label>
              <input type="text" class="form-control" id="tenCD" name="tenCD" placeholder="Nhập tên chủ đề" value="<?php if (isset($tenCD)) {
                  echo $tenCD;
              } ?>">
            </div>
            <input type="submit" class="btn btn-success" name="saveCD" value="Lưu">
            <a class="btn btn-success" href="ChuDeKhoaHoc.php?idKH=<?php echo $idKH; ?>">Trở lại</a>
        </form>
        </div>
	</main>
    <?php include "footer.php"; ?>
</body>
</html>


