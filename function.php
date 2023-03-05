<?php 

$folderBT = "assets/uploadFile/fileBaiTap/";
$folderBN = "assets/uploadFile/fileBaiNop/";
$folderHL = "assets/uploadFile/fileHocLieu/";
$folderKH = "assets/img_khoa_hoc/";       



// Đăng Ký
	function check_dangky($fullname, $user, $pass, $cfpass){
		if (empty($fullname) || empty($user) || empty($pass) || empty($cfpass)) {
			return "Bạn cần nhập đầy đủ thông tin";
		}else{
			$check = check_str("User Name",$user) .check_str("Password", $pass) .check_cfpass($pass, $cfpass);
		}

		return $check;
	}

	function check_str($str, $value){
		$kq = "";
		if (strlen($value) < 6) {
			$kq .= "$str phải có độ dài >= 6 ký tự <br>";
		}

		if (strpos($value, " ") == true) {
			$kq .= "$str không được chứa ký tự khoảng trắng <br>";
		}
		return $kq;
	}

	function check_cfpass($pass, $cfpass){
		$kq = "";

		if ($pass != $cfpass) {
			$kq .= "Password và Confirm Password phải trùng nhau <br>";
		}
		return $kq;
	}

	function check_userdb($user){
		GLOBAL $conn;
		$sql_select = "SELECT * FROM tb_tai_khoan WHERE ten_dang_nhap = '$user'";
		$query_sl = mysqli_query($conn, $sql_select);

		if (mysqli_num_rows($query_sl) == 1) {
			return true;	    
		}
		return false;      //User name chưa tồn tại trong db
	}


//Đăng nhập


	function check_dangnhapFail(){
		if (!isset($_COOKIE['dem'])) {
			$dem = 1;
			// setcookie('dem', $dem, time() + 180, "/");
		} else{
			$dem = $_COOKIE['dem'] + 1;
		}
		setcookie('dem', $dem, time() + 180, "/");
		// return $dem;
	}

	
	function check_dangnhap($user, $pass){
		GLOBAL $conn;

		if (check_userdb($user)) {
			$mk = selectTK($user) ['mat_khau'];
			if ($mk === $pass) {        //so sánh tuyệt đối
				$_SESSION['user'] = $user;
				return true;
			}
		}
		return false;
	}

	// function echoValue($str){
	// 	if (!empty($str)) {
	// 		echo $str;
	// 	}else echo "";
	// }

	//Truy vấn MySQL

	function selectTK($user){
		GLOBAL $conn;
		$sql = "SELECT * FROM tb_tai_khoan WHERE ten_dang_nhap = '$user'";
		$query = mysqli_query($conn, $sql);
		return mysqli_fetch_array($query);
	}

	function selectBT($idBT){
        GLOBAL $conn;
        $sql = "SELECT * FROM tb_bai_tap WHERE id = $idBT";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_array($query);
    }

?>



<?php 
	// Chủ Đề Khóa Học
	function getQuery($table, $colum, $id){
		GLOBAL $conn;
		$sql = "SELECT * FROM $table WHERE $colum = $id";
		return mysqli_query($conn, $sql);
	}



	function xoa($tableName, $id){
		GLOBAL $conn;
		$sql = "DELETE FROM $tableName WHERE id = $id";
		mysqli_query($conn, $sql);
	}

	//Xóa tất cả bài tập có id Chủ Đề  = $idCD
	function xoaBTCD($idCD){
		GLOBAL $conn;
		GLOBAL $folderBT;

		//Xóa bài tập
		$sql = "SELECT id, ten_file_bai_tap, ten_file_tai_lieu FROM tb_bai_tap WHERE id_chu_de = $idCD";
		$query = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($query)) {
			//Xóa bài nộp
			xoaBNBT($row['id']); 

			if (file_exists($folderBT .$row['ten_file_bai_tap'])) {
				unlink($folderBT .$row['ten_file_bai_tap']);
			}
			if (file_exists($folderBT .$row['ten_file_tai_lieu'])) {
				unlink($folderBT .$row['ten_file_tai_lieu']);
			}

			                      
			xoa("tb_bai_tap", $row['id']);               //Xóa row bài tập
		}
	}


	//Xóa tất cả bài nộp có id bài tập = $idBT
	function xoaBNBT($idBT){
		GLOBAL $conn;
		GLOBAL $folderBN;
		$sql = "SELECT id, ten_file_nop FROM tb_bai_nop WHERE id_bai_tap = $idBT";
		$query = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($query)) {
			if (file_exists($folderBN .$row['ten_file_nop'])) {
				unlink($folderBN .$row['ten_file_nop']);
			}
			xoa("tb_bai_nop", $row['id']);             //Xóa row bài nộp
		}
	}

	function delete_success(){
		echo 
			"
				<script type='text/javascript'>
					alert('Xóa thành công!!!');
				</script>
			";
	}

	function return_date_time($time){
        $ngay = (int)(($time / 3600) / 24);
        $gio = (int)(($time / 3600) % 24);
        $phut = (int)(($time / 60) % 60);
        $giay = (int)($time % 60);

        return $ngay .' ngày ' .$gio .' giờ ' .$phut .' phút ' .$giay .' giây';
    }


    function xoaTK($tableName, $username, $idRole){
		GLOBAL $conn;
		if ($idRole==2){
			return false;
		}else{
		$sql = "DELETE FROM $tableName WHERE ten_dang_nhap = '$username'";
		mysqli_query($conn, $sql);
		return true;
		}
	}
?>