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
            $flag = 0;
            $user = $_SESSION['user'];

            if (isset($_POST['btnCapNhap'])) {
                $flag = -1;
            }

            if (isset($_POST['btnLuu'])) {
                $flag = 1;
                $tenHT = trim($_POST['tenHT']);
                $ns = $_POST['ngaySinh'];
                $gt = $_POST['gioiTinh'];

                if (empty($tenHT) || empty($ns)) {
                    $kq = "Cần nhập đầy đủ thông tin";
                    $check = 0;
                }else {
                    $sql = "UPDATE tb_tai_khoan 
                            SET ten_hien_thi = '$tenHT', ngay_sinh = '$ns', gioi_tinh = $gt 
                            WHERE ten_dang_nhap = '$user'";
                    mysqli_query($conn, $sql);
                    $check = 1;
                    
                }
            }

             $infoTK = selectTK($user);
        ?>

    	<?php 
            include "navbar.php";
        ?>
        <div style="height: 86px;"></div>

        <?php 
            if (isset($check)) {
                if ($check == 1) {
                    echo "<div class='check'>Cập nhập thành công</div>";
                }else echo "<div class='check check_error'>$kq</div>";
            }
        ?>



        <div class="container" style="margin: 24px auto;">
            <form action="#" method="POST" class="p-3 w-75" style="background: #F3F3F3; margin: 0px auto;">
                <h3 class="text-uppercase text-center mb-4">Thông tin cá nhân</h3>
            
                <div class="w-50" style="margin: 0px auto;">
                    <div class="mb-1">
                        <label for="tenHT" class="form-label" style="width: 35%; text-align: left;">Họ Tên: </label>
                        <input type="text" name="tenHT" id="tenHT" style="width: 64%" 
                                <?php if (!isset($kq)  && $flag != -1) echo "disabled"; ?> value="<?php echo $infoTK['ten_hien_thi']; ?>">
                    </div>

                    <div class="mb-1">
                        <label for="ngaySinh" class="form-label" style="width: 35%; text-align: left;">Ngày sinh: </label>

                        <?php if ($infoTK['ngay_sinh'] == null && !isset($kq)  && $flag != -1) {
                            echo "Chưa cập nhật";
                        }else { ?>
                            <input type="date" name="ngaySinh" id="ngaySinh" min="1" <?php if (!isset($kq)  && $flag != -1) echo "disabled"; ?> value="<?php echo $infoTK['ngay_sinh']; ?>">
                        <?php } ?>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" style="width: 35%; text-align: left;">Giới tính: </label>
                    <?php if (!isset($kq)  && $flag != -1) { ?>
                        <label>
                            <?php
                                $GT = $infoTK['gioi_tinh'];
                                if ($GT == -1) {
                                    echo "Chưa cập nhập";
                                } elseif ($GT == 0) {
                                    echo "Nữ";
                                } else echo "Nam";
                            ?>
                         </label>
                    <?php }else { ?>
                        <input type="radio" name="gioiTinh" value="1" checked> 
                                <label style="margin-right: 24px;">Nam</label>
                        <input type="radio" name="gioiTinh" value="0" <?php if ($infoTK['gioi_tinh'] == 0) echo "checked"; ?>> <label>Nữ</label>
                    <?php } ?>
                    </div>

                    <?php 
                        if (!isset($kq)  && $flag != -1) {        //Lưu thông tin thành công
                            echo "<input type='submit' name='btnCapNhap' value='Cập nhập thông tin'  class='btn btn-warning mt-2 px-4'>";
                        }else {
                            echo "<input type='submit' name='btnLuu' value='Lưu'  class='btn btn-success mt-2 px-4'>";
                        }  
                    ?>
                    
                </div>
            </form>
        </div>
    </main>
    <?php include "footer.php"; ?>
</body>
</html>


