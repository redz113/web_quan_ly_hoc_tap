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
         
            $idBT = $_GET['idBT'];
            $row = selectBT($idBT);             //  97
        ?>
        <div style="height: 86px;"></div>


        <div id="action" style="margin: 20px 0 0 13%;">
            <a class="btn btn-success" href="ChuDeKhoaHoc.php?idKH=<?php echo $_SESSION['idKH']; ?>">Trở lại</a>
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%">

               <p class="h3 text-danger">Bài tập: <?php echo $row['ten_bai_tap']; ?> </p>

            <h4>Danh sách bài nộp:</h4>


            <?php 
                function trangThai($n){
                    if ($n == 0) {
                        return "Chưa duyệt";
                    } elseif ($n == 1) {
                        return "Đạt";
                    }
                    return "Chưa đạt";
                }
            ?>

            

            
            <table class="table table-bordered w-75" style="text-align: center; vertical-align: middle;">
                <tr style="background: #DADADA; font-size: 1.2rem;">
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Trạng thái duyệt</th>
                    <th>File nộp</th>
                    <th>Thời gian nộp</th>
                    <th>Thao tác</th>
                </tr>

            <?php
                if (isset($_POST['btnDat'])) {
                    $idBN = $_POST['id_phan_hoi'];
                    $n = 1;
                }

                if (isset($_POST['btnChuaDat'])) {
                    $idBN = $_POST['id_phan_hoi'];
                    $n = -1;
                }

                if (isset($n)) {
                    $sql = "UPDATE tb_bai_nop SET trang_thai = $n WHERE id= $idBN";
                    mysqli_query($conn, $sql);
                    unset($n);
                }
            
                $sqlBN = "SELECT * FROM tb_bai_nop WHERE id_bai_tap = $idBT";
                $queryBN = mysqli_query($conn, $sqlBN);
                $num = mysqli_num_rows($queryBN);

                if ($num <= 0) {
                    echo 
                    "
                        <tr bgcolor='pink'>
                            <td colspan='6'>Chưa có bài nộp</td>
                        </tr>
                    ";
                } else {
                    $dem = 1;
                    while ($rowBN = mysqli_fetch_array($queryBN)) {
                        
            ?>
                <tr style="<?php if ($dem % 2 == 0){
                    echo "background: #DADADA";
                } else  echo "background: #F4F4F4"; ?>">
                    <td width="10%"><?php echo $dem; ?></td>
                    <td width="20%"><?php 
                        $tk = selectTK($rowBN['ten_tai_khoan']);
                        echo $tk['ten_hien_thi']; ?>
                    </td>
                    <td width="15%">
                        <span class="h6">
                            <?php
                                $a = trangThai($rowBN['trang_thai']);
                                echo $a; 
                            ?>
                        </span>
                    </td>
                    <td width="20%"><a target="_blank" href="<?php echo $folderBN . $rowBN['ten_file_nop']; ?>"><?php echo $rowBN['ten_file_nop']; ?></a></td>
                    <td width="20%"><?php echo $rowBN['thoi_gian_nop']; ?></td>
                    <td width="15%" style="background: #F2F2F2;">
                        <form method="post" name="formThayDoiTrangThai">
                            <input type="hidden" value="<?php echo $rowBN['id']; ?>" name="id_phan_hoi">
                        <?php if ($rowBN['trang_thai'] != 1) { ?>
                            <input type="submit" name="btnDat" value="Đạt" class="btn btn-outline-success">
                        <?php 
                                }
                            if ($rowBN['trang_thai'] != -1) {
                        ?>
                            <input type="submit" name="btnChuaDat" value="Chưa đạt" class="btn btn-outline-warning">
                        <?php } ?>
                        </form>
                    </td>
                </tr>

            <?php 
                $dem += 1;
                    }
                }
            ?>
            </table>
            

            

        </div>

    </main>
    <?php include "footer.php"; ?>
</body>
</html>


