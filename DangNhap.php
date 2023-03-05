<?php 
	include "./Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Đăng Nhập</title>
	<link rel="stylesheet" type="text/css" href="./assets/cssX/style1.css">
	<link rel="stylesheet" type="text/css" href="assets/cssX/check.css">
</head>
<body>

	<?php 
	$user = $pass = "";

	if (isset($_POST['submit'])) {
		$user = trim($_POST['username']);
		$pass = trim($_POST['password']);

		if (empty($user) || empty($pass)) {
			echo "<div class = 'check check_error'> Hãy nhập đầy đủ thông tin </div>";	
		}else {
			if (check_dangnhap($user, $pass) && (!isset($_COOKIE['dem']) || $_COOKIE['dem'] <3)){			//69
				if (isset($_COOKIE['dem'])) setcookie('dem', $_COOKIE['dem'], time() - 180, "/");   //xóa bỏ biến đếm
				$_SESSION['user'] = $user;
				echo "<div class = 'check'> Đăng nhập thành công </div>";
				header("refresh: 0.75; url= KhoaHoc.php");
			}else {
				$kq = "Tên đăng nhập hoặc mật khẩu không chính xác";
				check_dangnhapFail();			//57
				if (isset($_COOKIE['dem']) && $_COOKIE['dem'] >= 3) {
					$kq = "Bạn đã nhập sai 3 lần liên tiếp, hãy quay lại sau 3 phút";
				}

				echo "<div class = 'check check_error'> $kq </div>";
			}
		}
	}
	?>
	<div class="main">
		<div class="content" style="margin-top: 60px;">
			<div class="title">Đăng Nhập</div>
			<div class="form">
				<form method="post" action="#">
					<div class="input-1">
						<label for="ip-un">User Name</label>
						<input type="text" name="username" id="ip-un" placeholder="Username..." value="<?php echo $user; ?>">
					</div>
					<div class="input-1">
						<label for="ip-pw">Password</label>
						<input type="password" name="password" id="ip-pw" placeholder="Password..." value="<?php echo $pass; ?>">
					</div>
					<div style="height: 12px;"></div>
					
					<input style="background: blue;" class="btn-submit" type="submit" name="submit" value="Đăng Nhập">
					
				</form>
				<div class="link">
					<a href="DangKy.php">Đăng ký tài khoản</a>
				</div>

				<div class="clear"></div>
			</div>
		</div>
	</div>
</body>
</html>

<?php 
?>