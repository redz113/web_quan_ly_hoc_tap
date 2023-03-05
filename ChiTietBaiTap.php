<?php include "Connect.php"; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sửa Bài Tập</title>
	<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/cssX/check.css">
</head>


<body>

<?php
	include "navbar.php";
?>

<div style="height: 86px;"></div>



<?php 
	$user = $_SESSION['user'];
	$idKH = $_SESSION['idKH'];
	$idBT = $_GET['idBT'];

	$BT = selectBT($idBT);			//	97

	$kq = "";
	if (isset($_POST['btnNopBai'])) {
		$time = date_timestamp_get(date_create($BT['han_nop'], timezone_open("Asia/Ho_Chi_Minh"))) - time();
		if ($time > 0) {
			$countBN = $BT['so_bai_thu'] - CountBN($BT['id']);    //Số lượng bài thu còn lại
			if ($countBN > 0) {
				$kq = NopBai($idBT);        
			}else {$kq = "Số bài thu đã đủ";}	
		}else {$kq = "Bài nộp đã hết hạn";}

		if (!empty($kq)) {
			echo "<div class='check check_error'>$kq</div>";
		}
	}

	$fileDaNop = fileDaNop($idBT);
	
?>

<?php 
	// Function
	function CountBN($id){
		GLOBAL $conn;
		$sql = "SELECT COUNT(id) AS num FROM tb_bai_nop WHERE id_bai_tap = $id";
		$query = mysqli_query($conn, $sql);

		return mysqli_fetch_array($query)['num'];
	}

	function fileDaNop($idBT){
		GLOBAL $conn;
		$user = $_SESSION['user'];

		$sql = "SELECT id, ten_file_nop FROM tb_bai_nop WHERE id_bai_tap = $idBT AND ten_tai_khoan = '$user'";
		$query = mysqli_query($conn, $sql);
		return mysqli_fetch_array($query);
	}

	function NopBai($idBT){
		GLOBAL $conn;
		GLOBAL $folderBN;
		$user = $_SESSION['user'];
		$kqNB = "";

		//Kiểm tra file nộp
		$fileDaNop = fileDaNop($idBT);
		

		$file = $_FILES['file_nop'];
		if (empty($file['name'])) {
			$kqNB = "Hãy chọn file nộp";
		}else{
			$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			$arrExtension = ["zip", "rar", "pdf", "php", "html"];
			if (in_array($extension, $arrExtension)) {
				$fileName = "BN_" .floor(microtime(true) * 10000) . "." . $extension;		
				if (isset($fileDaNop) && file_exists($folderBN .$fileDaNop['ten_file_nop'])) {
					$id = $fileDaNop['id'];
					unlink($folderBN .$fileDaNop['ten_file_nop']);
					$sql = "UPDATE tb_bai_nop SET ten_file_nop = '$fileName' WHERE id = $id AND ten_tai_khoan = '$user'";
					echo "<div class='check'>Sửa thành công</div>";
				}else{
					$sql = "INSERT INTO tb_bai_nop(id_bai_tap, ten_tai_khoan, ten_file_nop) VALUES($idBT, '$user', '$fileName')";
					echo "<div class='check'>Nộp thành công</div>";
				}
				move_uploaded_file($file['tmp_name'], $folderBN .$fileName);
				mysqli_query($conn, $sql);
			}else{
				$kqNB = "Bài nộp chỉ nhận các file có đuôi .pdf .php .html .rar .rip";
			}
		}
		return $kqNB;
	}

?>
	<main style="min-height: 100vh; max-width: 100%;">
		<div id="action" style="margin: 20px 0 0 13%;">
			<a class="btn btn-success" href="ChuDeKhoaHoc.php?idKH=<?php echo $idKH; ?>">Trở lại</a>
		</div>
		<div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%">
			<div class="card" style="height: 80vh; width: 80%;">
				<div class="card-header h4">
					<?php echo $BT['ten_bai_tap']; ?>
				</div>
				<div class="card-body">
					<iframe width="100%" height="100%" src="<?php echo $folderBT . $BT['ten_file_bai_tap']; ?>"></iframe>
				</div>
			</div>

			<br>
			<?php
            if (isset($kq)) {
	            echo $kq;
            }
            ?>
			<!-- <div class='alert alert-success text-center w-50' role='alert'>Nộp thành công</div> -->
			<table class="table table-bordered w-75 mt-5">
			<?php if (!empty($BT['ten_file_tai_lieu'])) { ?>
				<tr style="background: #FFF0AA;">
					<td>File tài liệu</td>
					<td>
						<a href="<?php echo $folderBT .$BT['ten_file_tai_lieu']; ?>"> <?php echo $BT['ten_file_tai_lieu']; ?> </a>
					</td>
				</tr>
			<?php } ?>
				<tr>
					<td>Hạn nộp</td>
					<td>
						<?php echo $BT['han_nop']; ?>
					</td>
				</tr>

				<tr>
					<td>Số bài nộp nhận tối đa</td>
					<td>
						<?php echo $BT['so_bai_thu']; ?>
					</td>
				</tr>

				<!-- Phân quyền -->
			<?php if ($_SESSION['doiTuong'] != 1) { ?>
				<tr>
					<td>File đã nộp</td>
					<td>
						<?php
                        if (!isset($fileDaNop)) {
	                        echo "Chưa nộp";
                        } else {
	                        $fullpath = $folderBN . $fileDaNop['ten_file_nop'];
	                        echo "<a href='$fullpath' target='_blank'>" .$fileDaNop['ten_file_nop'] ."</a>";
                        }
                        ?>
					</td>
				</tr>
			<?php } ?>
			</table>

			<?php
            ?>

            <?php 
            	if ($_SESSION['doiTuong'] == 0) { ?>
			<form action="" method="POST" enctype="multipart/form-data" class="w-75 mt-3">
				<div class="mb-3">
					<label for="file_nop" class="form-label h4" style="margin-left: 8px; margin-bottom: 12px;">Nộp bài</label>
					<input type="file" class="form-control" id="file_nop" name="file_nop">
				</div>
				<input type="submit" class="btn btn-primary" name="btnNopBai" value="Nộp bài">
			</form>
			<<?php } ?>
		</div>
	</main>

	<?php include "footer.php"; ?>


</html>