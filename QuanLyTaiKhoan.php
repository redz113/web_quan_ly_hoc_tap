<?php 
	include "Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quản lý tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
	<style type="text/css">
		#table{
			margin: 20px auto;
		}
		.rows{
			height: 100px;
		}
		.col{
			
			border: 1px solid black;
		}
	</style>
</head>
<body id="page-top">
	<main style="min-height: 90vh; max-width: 100%;">
		<?php
			include "navbar.php";
		 ?>
		<div style="height: 86px;"></div>
		<div class="row row-cols-1 row-cols-md-2 g-4 mb-4" style="margin: 0 auto; width: 90%;">
		<?php 
			$info = array();
			$sql = 'SELECT * FROM tb_tai_khoan';
			$query = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
				$info[] = $row;
			}
			// echo "<pre>";
			// print_r($info);
			// echo "</pre>";
		?>
			<table id="table" align="center" style="text-align: center;">
				<tr class='rows'>
					<th class='col'>Tên đăng nhập</th>
					<th class='col'>Tên hiển thị</th>
					<th class='col'>Mật khẩu</th>
					<th class='col'>Đối tượng</th>
					<th class='col'>Ngày sinh</th>
					<th class='col'>Giới tính</th>
					<th class='col'>Thao tác</th>
				</tr>
				<?php 
					for ($i=0; $i < count($info); $i++) { 
						echo "<tr class='rows'>";
						for ($j=0; $j < count($info[$i]); $j++) { 
							echo "<td class='col'>".$info[$i][$j]."</td>";
						}
						echo '<td class="col">
						<form class="d-inline-block" method="POST" action="XoaTaiKhoan.php?tenTK='.$info[$i][0].'&idRole='.$info[$i][3].'" onsubmit="return confirmDelete()">
				            <button class="btn btn-outline-danger" type="submit" name="btnXoa">Xóa</button>
				        </form>
				    	</td>';
						echo "</tr>";
					}
					 ?>
			</table>
			
		</div>
	</main>
	
		<?php
		include 'footer.php';
	?>
</body>
</html>
<script type="text/javascript">
    function confirmDelete(){
       if(confirm("Xóa tài khoản? "))
         return true;
      
      return false;
    }
</script>