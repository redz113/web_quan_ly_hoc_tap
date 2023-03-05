<?php 
	include "./Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Đăng Ký</title>
	<link rel="stylesheet" type="text/css" href="./assets/cssX/style1.css">
	<link rel="stylesheet" type="text/css" href="assets/cssX/check.css">
</head>
<body>
	<?php 
		$flag = 0;

		if (isset($_POST['submit'])) {
			$fullname = trim($_POST['fullname']);
			$user = trim($_POST['username']);
			$pass = trim($_POST['password']);
			$cfpass = trim($_POST['cfpassword']);

			$kq = check_dangky($fullname, $user, $pass, $cfpass);			//11
			if ($kq == "") {
				$flag = 1;
			}else echo "<div class = 'check check_error'> $kq </div>";
		}

		if ($flag == 1) {
			if (!check_userdb($user)) {			//42
				$sql_insert = "INSERT INTO tb_tai_khoan VALUES('$user', '$fullname', '$pass', 0, NULL, -1)";
				mysqli_query($conn, $sql_insert);
				echo "<div class = 'check'> Đăng Ký Thành Công </div>";
			}else echo "<div class = 'check check_error'> User Name đã tồn tại </div>";
		}
	?>
	<div class="main">
		<div class="content">
			<div class="title">Đăng Ký</div>
			<div class="form">
				<form method="post" action="">
					<div class="input-1">
						<label for="ip-fn">Full Name</label>
						<input type="text" name="fullname" id="ip-fn" placeholder="Fullname..." value="<?php if(isset($fullname)) echo $fullname; else echo ""; ?>" >
					</div>
					<div class="input-1">
						<label for="ip-un">User Name</label>
						<input type="text" name="username" id="ip-un" placeholder="Username..." value="<?php if(isset($user)) echo $user; else echo ""; ?>">
					</div>
					<div class="input-1">
						<label for="ip-pw">Password</label>
						<input type="password" name="password" id="ip-pw" placeholder="Password..." value="<?php if(isset($pass)) echo $pass; else echo ""; ?>">
					</div>
					<div class="input-1">
						<label for="ip-cfpw">Confirm Password</label>
						<input type="password" name="cfpassword" id="ip-cfpw" placeholder="Confirm password..." value="<?php if(isset($cfpass)) echo $cfpass; else echo ""; ?>">
					</div>
					<div style="height: 12px;"></div>
					
					<input class="btn-submit" type="submit" name="submit" value="Đăng Ký">
					
				</form>
				<div class="link">
					<a href="DangNhap.php">Đăng nhập tài khoản</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</body>
</html>