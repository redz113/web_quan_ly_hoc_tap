<?php 
	include "Connect.php";
	unset($_SESSION['idKH']);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Khóa Học</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
	<style type="text/css">
		.deleteKH{
			border: none;
			font-size: 24px;
			text-decoration: none;
			color: #8A8A8A;
			background: rgba(255, 255, 255, 0.2);
			padding: 0px 8px;
			position: absolute; 
			top: 0; 
			right: 0;"
		}

		.deleteKH:hover{
			background: rgba(255, 222, 222, 0.6);
		}
	</style>
</head>
<body id="page-top">

	<main style="min-height: 90vh; max-width: 100%;">
	<?php include "navbar.php"; ?>

	<div style="height: 86px;"></div>
		<div class="row row-cols-1 row-cols-md-3 g-4 mb-4" style="margin: 0 auto; width: 90%;">
			<!-- begin khóa học -->
	<?php 
		$sql = "SELECT * FROM tb_khoa_hoc";
		$query = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($query)) {
	?>
			  <div class="col">
			    <div class="card" style="position: relative;">

<!-- Phân quyền hiển thị đối với Giáo viên - 1 và Admin - 2 -->
			<?php if ($_SESSION['doiTuong'] != 0) { ?>

				 <!-- Xóa Khóa Học -->
			    <form method="POST" action="XoaKhoaHoc.php?idKH=<?php echo $row['id_khoa_hoc']; ?>" 
			    	onsubmit="return confirm_delete()">
					<button class="deleteKH" type="submit"><i class="ri-close-fill" ></i></button>
				</form>
				<!--  -->
			<?php } ?>
			      <img src="<?php echo $folderKH . $row['path_img']; ?>" class="card-img-top" height = "200vh" alt="Course Image">
			      <div class="card-body">
			        <h5 class="card-title text-capitalize" style="min-height: 50px"><?php echo $row['ten_khoa_hoc']; ?></h5>
			        <a href="ChuDeKhoaHoc.php?idKH=<?php echo $row['id_khoa_hoc']; ?>" style="display: block;" class="btn btn-success">Vào học</a>
			      </div>
			    </div>
			  </div>

	<?php 
		}; 

		if ($_SESSION['doiTuong'] != 0) {
	?>	
			<!-- Thêm Khóa Học -->
			<div class="col d-flex flex-wrap align-content-center" style="font-size: 4rem;">
			      <a href="ThemKhoaHoc.php" style="text-decoration: none;"><i class="ri-add-circle-line"></i></a>
			</div>
			<!--  -->
		<?php }; ?>
		</div>
	</main>

	<?php include "footer.php"; ?>
</body>
</html>

<script type="text/javascript">
    function confirm_delete(){
       if(confirm("Xóa khóa học? "))
         return true;
      
      return false;
    }
</script>