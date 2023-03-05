<?php 
	include "Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bài Luyện tập</title>
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
            $idBL = $_GET['idBL'];
            if (isset($_POST['saveCD'])) {
                $tenCH = trim($_POST['tenCH']);
                $daA = trim($_POST['daA']);
                $daB = trim($_POST['daB']);
                $daC = trim($_POST['daC']);
                $daD = trim($_POST['daD']);
                $dapAn = $_POST['dapAn'];

                if (empty($tenCH) || empty($daA) || empty($daB) || empty($daC) || empty($daD) || $dapAn == "0") {
                     echo "<div class='check check_error'>Cần nhập đầy đủ thông tin</div>";
                }else {
                    $sql = "INSERT INTO tb_cau_hoi(id_bai_luyen_tap, ten_cau_hoi, da_A, da_B, da_C, da_D, dap_an)
                        VALUES($idBL, '$tenCH', '$daA', '$daB', '$daC', '$daD', '$dapAn')";
                    mysqli_query($conn, $sql);
                     echo "<div class='check'>Thêm thành công</div>";
                }
            }
        ?>

    	<div class="d-flex justify-content-center mt-5">
        <form action="" method="POST" class="w-75">
            <h3>Câu hỏi luyện tập</h3>
            <div class="mb-3">
              <label for="tenCH" class="form-label">Câu hỏi</label>
              <input type="text" class="form-control" id="tenCH" name="tenCH" placeholder="Nhâp câu hỏi" value="<?php if (isset($tenCH)) {
                  echo $tenCH;
              } ?>">
            </div>
            <div class="mb-3">
              <label for="daA" class="form-label">Đáp án A</label>
              <input type="text" class="form-control" id="daA" name="daA" placeholder="..." value="<?php if (isset($daA)) {
                  echo $daA;
              } ?>">
            </div>

            <div class="mb-3">
              <label for="daB" class="form-label">Đáp án B</label>
              <input type="text" class="form-control" id="daB" name="daB" placeholder="..." value="<?php if (isset($daB)) {
                  echo $daB;
              } ?>">
            </div>

            <div class="mb-3">
              <label for="daC" class="form-label">Đáp án C</label>
              <input type="text" class="form-control" id="daC" name="daC" placeholder="..." value="<?php if (isset($daC)) {
                  echo $daC;
              } ?>">
            </div>

            <div class="mb-3">
              <label for="daD" class="form-label">Đáp án D</label>
              <input type="text" class="form-control" id="daD" name="daD" placeholder="..." value="<?php if (isset($daD)) {
                  echo $daD;
              } ?>">
            </div>

            <div class="mb-1">
                <label for="loaiTK" class="form-label">Đáp án câu hỏi </label>
                <select class="text-center" name="dapAn">
                    <option value="0" selected>---</option>
                    <option value="A" <?php if (isset($dapAn) && $dapAn == "A") echo "selected"; ?>>A</option>
                    <option value="B" <?php if (isset($dapAn) && $dapAn == "B") echo "selected"; ?>>B</option>
                    <option value="C" <?php if (isset($dapAn) && $dapAn == "C") echo "selected"; ?>>C</option>
                    <option value="D" <?php if (isset($dapAn) && $dapAn == "D") echo "selected"; ?>>D</option>
                </select>
            </div>

            <input type="submit" class="btn btn-success" name="saveCD" value="Lưu">
            <a class="btn btn-success" href="TruyCapBaiLuyen.php?idBL=<?php echo $idBL; ?>">Trở lại</a>
        </form>
        </div>
	</main>
    <?php include "footer.php"; ?>
</body>
</html>


