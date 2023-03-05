<?php 
	include "./Connect.php";

	if (!isset($_SESSION['user'])) {
		header("location: DangNhap.php");
		exit();
	}

	$tendangnhap = $_SESSION['user'];

	if (isset($_POST['submit'])) {
		$pre_pass = trim($_POST['pre_pass']);
		$new_pass1 = trim($_POST['new_pass']);
		$new_pass2 = trim($_POST['cfnew_pass']);

		$kq = "";

		if (trim($pre_pass) == "" || trim($new_pass1) == "" || trim($new_pass2) == "") {
			$kq .= "Hãy điền đầy đủ thông tin <br>";
		}else { 
			$sql1 = "SELECT * FROM tb_tai_khoan WHERE ten_dang_nhap = '$tendangnhap' AND mat_khau = '$pre_pass'";
			$query = mysqli_query($conn, $sql1);
			$num = mysqli_num_rows($query);

			if ($num != 1) {
			$kq .= "Mật khẩu hiện tại không chính xác <br>";
			}else{
				if (check_str("", $new_pass1) != "" || check_str("", $new_pass2) != "") {                              //21-function
					$kq .= "Mật khẩu mới phải có độ dài >= 6 ký tự và không chứa kí tự khoảng trống <br>";
				}elseif ($new_pass1 == $new_pass2) {
					$sql2 = "UPDATE tb_tai_khoan SET mat_khau = '$new_pass1' WHERE ten_dang_nhap = '$tendangnhap'";
					mysqli_query($conn, $sql2);

					echo "
					<script type='text/javascript'>
						alert('Đổi mật khẩu thành công');
					</script>
					";
					
					header("refresh: 0; url =DangXuat.php");
				}else $kq = "Mật khẩu xác nhận không trùng khớp <br>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Đổi mật khẩu</title>
	<link rel="stylesheet" type="text/css" href="./assets/cssX/style1.css">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</head>
<body>

	<?php 
		include "navbar.php";
	?>

	<div style="height: 86px;"></div>

	<div class="main">
		<div class="content">
			<div class="title">Đổi Mật Khẩu</div>
			<div class="form">
				<form method="post" action="#">
					<div class="input-1">
						<label for="ip-un">Tên đăng nhập</label>
						<input type="text" disabled name="pre_pass" id="ip-un" placeholder="" value="<?php echo $tendangnhap; ?>">
					</div>

					<div class="input-1">
						<label for="ip-pw0">Mật khẩu cũ</label>
						<input type="password" name="pre_pass" id="ip-pw0" placeholder="" value="<?php if(isset($pre_pass)) echo $pre_pass; ?>">
					</div>

					<div class="input-1">
						<label for="ip-pw1">Mật khẩu mới</label>
						<input type="password" name="new_pass" id="ip-pw1" placeholder="" value="<?php if(isset($new_pass1)) echo $new_pass1; ?>">
					</div>

					<div class="input-1">
						<label for="ip-pw2">Nhập lại mật khẩu</label>
						<input type="password" name="cfnew_pass" id="ip-pw2" placeholder="" value="<?php if(isset($new_pass2)) echo $new_pass2; ?>">
					</div>

					<div class="input-1" style="font-size: 13px; color: red; text-align: left;">
						<?php 
							if (isset($kq)) echo "<div> $kq </div>";
						?>
					</div>
					<div style="height: 12px;"></div>
					
					<input style="background: blue;" class="btn-submit" type="submit" name="submit" value="Xác nhận">
					
				</form>
				<div class="clear"></div>
			</div>
		</div>
	</div>

	<?php 
		include "footer.php";
	?>
</body>
</html>

<?php 
?>