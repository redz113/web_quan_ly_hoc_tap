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
            $flag = 0;

            if (isset($_POST['btnTao'])) {
                $sl = $_POST['slTK'];
                $ten = trim($_POST['tenTK']);
                $mk = trim($_POST['mk']);
                $doiTuong = $_POST['doiTuong'];

                if (isset($sl) && !empty($ten) && !empty($mk) && $doiTuong != -1) {
                    $flag = 1;
                }else{
                    $flag = 0;
                    echo  "<div class='check check_error'>Cần nhập đầy đủ thông tin</div>";
                }
            }
        ?>

        <div class="container" style="margin: 24px auto;">
            <form action="#" method="POST" class="p-3 w-75" style="background: #F3F3F3; margin: 0px auto;">
                <h3 class="text-uppercase text-center mb-4">Tạo tài khoản tự động</h3>
            
                <div class="w-50" style="margin: 0px auto;">
                    <div class="mb-1">
                        <label for="tenTK" class="form-label" style="width: 35%; text-align: left;">Tên mặc định: </label>
                        <input type="text" name="tenTK" id="tenTK" style="width: 64%" placeholder="Nhập tên tài khoản mặc định..." value="<?php if (isset($ten)) echo $ten; ?>">
                    </div>

                    <div class="mb-1">
                        <label for="mk" class="form-label" style="width: 35%; text-align: left;">Mật khẩu mặc định: </label>
                        <input type="text" name="mk" id="mk" style="width: 64%" placeholder="Nhập mật khẩu mặc định..." value="<?php if (isset($mk)) echo $mk; ?>">
                    </div>

                    <div class="mb-1">
                        <label for="slTK" class="form-label" style="width: 35%; text-align: left;">Số lượng tài khoản: </label>
                        <input type="number" name="slTK" id="slTK" min="1" value="<?php if (isset($sl)) echo $sl; ?>">
                    </div>
                    <div class="mb-1">
                        <label for="loaiTK" class="form-label" style="width: 35%; text-align: left;">Loại tài khoản: </label>
                        <select class="text-center" name="doiTuong">
                            <option value="-1" selected>---</option>
                            <option value="0" <?php if (isset($doiTuong) && $doiTuong == 0) {
                                echo "selected"; } ?>>Học Viên</option>
                        <?php if ($_SESSION['doiTuong'] == 2) { ?>
                            <option value="1" <?php if (isset($doiTuong) && $doiTuong == 1) {
                                echo "selected"; } ?>>Giáo Viên</option>
                            <option value="2" <?php if (isset($doiTuong) && $doiTuong == 2) {
                                echo "selected"; } ?>>Admin</option>
                        <?php } ?>
                        </select>
                    </div>

                    <input type="submit" name="btnTao" value="Tạo"  class="btn btn-success mt-2 px-4">
                </div>
            </form>
        </div>


        <?php 
            if ($flag == 1) {
        ?>
        <h3 style="text-align: center;">Thông Tin Tài Khoản Tạo Mới</h3> 
         <table class="table table-bordered w-50" align="center" style="text-align: center; vertical-align: middle; border: 2px solid black;" border="2">
            <tr style="background: #DADADA; font-size: 1.2rem;">
                <th width="10%">STT</th>
                <th>Tên tài khoản</th>
                <th>Tên hiển thị</th>
                <th>Mật khẩu</th>
            </tr>


            <?php 
            // $sql = "SELECT * FROM tb_tai_khoan WHERE ten_dang_nhap LIKE '$ten%'";
            // $query = mysqli_query($conn, $sql);
            // $num = mysqli_num_rows($query);
            // echo $num;
            
            $i = 1;
            $x = 0;

            while($i != $sl + 1) { 
                $tenTK = $ten .$i;

                $row = selectTK($tenTK);            // 90
                if (isset($row)) {
                    $x++;
                    $i++;
                    $sl++;
                }else{
                    $sql = "INSERT INTO tb_tai_khoan(ten_dang_nhap, ten_hien_thi, mat_khau, doi_tuong)
                                VALUES('$tenTK', '$tenTK', '$mk', $doiTuong)";
                    mysqli_query($conn, $sql);
            ?>
            <tr style="<?php if ($i % 2 == 0){
                    echo "background: #DADADA";
                } else  echo "background: #F4F4F4"; ?>">
                <td><?php echo $i - $x; ?></td>
                <td><?php echo $tenTK; ?></td>
                <td><?php echo $tenTK; ?></td>
                <td><?php echo $mk; ?></td>
            </tr>
            <?php
                        $i++;
                    }
                } 
            ?>
        </table>

        <?php } ?>



    </main>
    <?php include "footer.php"; ?>
</body>
</html>


