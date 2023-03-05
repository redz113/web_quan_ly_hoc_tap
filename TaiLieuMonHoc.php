<?php 
	include 'Connect.php';
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tài liệu môn học</title>
	<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
	<style type="text/css">
		.frame{
			width: 100%;
			min-height: 500px;
		}
	</style>
</head>
<body>
	<?php 
		include 'navbar.php';
		if (isset($_SESSION['idKH'])) {
			$idKH=$_SESSION['idKH'];
			$role = $_SESSION['doiTuong'];
			$sql='SELECT id, ten_hoc_lieu, ten_file_hoc_lieu FROM tb_hoc_lieu WHERE id_khoa_hoc='.$idKH.'';
			$query=mysqli_query($conn, $sql);
        }else{
            header("location: KhoaHoc.php");
            die();
            }
	 ?>
	 <div style="height: 86px;"></div>
	 <div id="action" style="margin: 20px 0 0 2%;">
            <a href="ChuDeKhoaHoc.php?idKH=<?php echo $idKH; ?>" class="btn btn-success">Trở lại</a>
            <?php 
                if ($role==1 || $role==2) {
            ?>
            <a href="ThemHocLieu.php?idKH=<?php echo $idKH; ?>" class="btn btn-success">Thêm học liệu</a>
        	<?php } ?>
     </div>
     <div class="container w-75">
     		<?php 
     			while ($rowHL=mysqli_fetch_array($query)) {
     		?>
     		<div class="text-uppercase my-4">
                <a class="text-dark" style="text-decoration: none;" data-bs-toggle="collapse" style="font-weight: 700;" href="#collapseExample<?php echo $rowHL['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $rowHL['id']; ?>">
		     		<div class="card" style="background: #DADADA;">
		                <div class="card-body">
			     			<div class="h3">
			     				<?php echo $rowHL['ten_hoc_lieu']; 
			     				    if ($role==1 || $role==2) {
			     				?>
			     				<a href="SuaHocLieu.php?idKH=<?php echo $idKH; ?>&idHL=<?php echo $rowHL['id']; ?>" class="btn btn-success">Sửa học liệu</a>
			     				<a href="XoaHocLieu.php?idKH=<?php echo $idKH; ?>&idHL=<?php echo $rowHL['id']; ?>" class="btn btn-success">Xóa học liệu</a>
			     				<?php } ?>
			     			</div>
			     		</div>
			     	</div>
			    </a>
            </div>
            <div class="collapse" id="collapseExample<?php echo $rowHL['id']; ?>">
            	<iframe src="<?php echo $rowHL["ten_file_hoc_lieu"]; ?>" class="frame"></iframe>
            </div>
     		<?php
     			}
     		?>
     </div>

</body>
</html>