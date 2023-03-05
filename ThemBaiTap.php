<?php 
	include "Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Thêm Bài Tập</title>
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
            $idCD = $_GET['idCD'];
            $flag = 0;

            if (isset($_POST['saveBT'])) {
                $tenBT = trim($_POST['tenBT']);
                $soBaiThu = $_POST['so_bai_thu'];
                $hanNop = $_POST['han_nop'];
                $fileDB = $_FILES['file_de_bai'];              //file đề bài
                $fileTL = $_FILES['file_tu_lieu'];             //file tư liệu

                if (empty(trim($tenBT))) {
                    $kq = "Tên bài tập?";
                }elseif (empty($hanNop)) {
                    $kq = "Hạn nộp bài tập?";
                }elseif (empty($fileDB['name'])) {
                    $kq = "File nộp bài tập?";
                }

                if (!empty($fileTL['name'])) {
                    $extension1 = strtolower(pathinfo($fileTL['name'], PATHINFO_EXTENSION));

                    // hàm trả về thời gian dạng phần 100 của giây  
                    // floor: làm tròn đến số nguyên gần nhất
                    $tenFileTL = "TL_" .floor(microtime(true) * 100) ."." .$extension1; 
                    $flag = 1;    
                }


                if (empty($soBaiThu)) {
                    //Số bài thu  = tổng ds tài khoản
                    $sql = "SELECT COUNT(ten_dang_nhap) AS num FROM tb_tai_khoan";
                    $soBaiThu = mysqli_fetch_array(mysqli_query($conn, $sql)) ['num'];
                }


                if (isset($kq)) {
                    echo "<div class='check check_error'>$kq</div>";
                } else {
                    $extension2 = strtolower(pathinfo($fileDB['name'], PATHINFO_EXTENSION));
                    if ($extension2 == "pdf") {
                        //hàm trả về thời gian dạng phần 1000 của giây
                        $tenFileBT = "BT_" .floor(microtime(true) * 1000) ."." .$extension2; 

                        move_uploaded_file($fileDB['tmp_name'], $folderBT . $tenFileBT);
                        if ($flag == 1) {
                            move_uploaded_file($fileTL['tmp_name'], $folderBT . $tenFileTL);
                            $sql = "INSERT INTO tb_bai_tap(id_chu_de, ten_bai_tap, so_bai_thu, han_nop, ten_file_bai_tap,  ten_file_tai_lieu)
                            VALUES($idCD, '$tenBT', $soBaiThu, '$hanNop', '$tenFileBT', '$tenFileTL')";
                        }else{
                            $sql = "INSERT INTO tb_bai_tap(id_chu_de, ten_bai_tap, so_bai_thu, han_nop, ten_file_bai_tap)
                            VALUES($idCD, '$tenBT', $soBaiThu, '$hanNop', '$tenFileBT')";
                        }

                        mysqli_query($conn, $sql);
                        echo "<div class='check'>Thêm bài tập thành công</div>";             
                    }else {
                        echo "<div class='check check_error'>File bài tập chỉ nhận đuôi .pdf</div>";
                    } 
                }
                
            } 

            // $query = getQuery('tb_chu_de', 'id', $idCD);
            // $row = mysqli_fetch_array($query);

        ?>

    	<div class="d-flex justify-content-center mt-3">
            <form action="" method="POST" enctype="multipart/form-data" class="w-50">
                <h3>Thêm bài tập</h3>
                <div class="mb-3">
                  <label for="tenBT" class="form-label">Tên chủ đề</label>
                  <input type="text" class="form-control" id="tenBT" name="tenBT" placeholder="Nhập tên bài tập" value="<?php if (isset($tenBT)) {
                      echo $tenBT;
                  } ?>">
                </div>
                <div class="mb-3">
                  <label for="so_bai_thu" class="form-label">Số bài thu</label>
                  <input type="number" class="form-control" id="so_bai_thu" min="0" name="so_bai_thu" placeholder="Nhập Số bài thu tối đa" value="<?php if (isset($soBaiThu)) {
                      echo $soBaiThu;
                  } ?>">
                </div>
                <div class="mb-3">
                  <label for="han_nop" class="form-label">Hạn nộp</label>
                  <input type="datetime-local" class="form-control" id="han_nop" name="han_nop" placeholder="Nhập hạn nộp" value="<?php if (isset($hanNop)) {
                      echo $hanNop;
                  } ?>">
                </div>
                <div class="mb-3">
                  <label for="file_de_bai" class="form-label">Chọn file đề bài</label>
                  <input type="file" class="form-control" id="file_de_bai" name="file_de_bai">
                </div>
                <div class="mb-3">
                  <label for="file_tu_lieu" class="form-label">Chọn file tư liệu (Nếu có)</label>
                  <input type="file" class="form-control" id="file_tu_lieu" name="file_tu_lieu">
                </div>
                <input type="submit" class="btn btn-success" name="saveBT" value="Lưu">
                <a href="ChuDeKhoaHoc.php?idKH=<?php echo $idKH; ?>" class="btn btn-success">Trở lại</a>

            </form>
        </div>
	</main>
    <?php include "footer.php"; ?>
</body>
</html>


