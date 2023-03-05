<?php 
	if (!isset($_SESSION['user'])) {
		header("location: DangNhap.php");
	}else{
		// 0 - Học viên
		// 1 - Giáo viên
		// 2 - Admin
		$_SESSION['doiTuong'] = selectTK($_SESSION['user'])['doi_tuong'];			// 	90
	}
?>


<style type="text/css">
	.navbar .text-nav:hover{
		text-shadow: 0px 2px 2px red;
		transform: translateY(-1px) translateX(1px);
		transition: font-size 0.1s;
	}
</style>


<nav class="navbar navbar-expand-lg text-uppercase fixed-top bg-success" id="mainNav">
        <div class="container-fluid">
            	<a class="navbar-brand px-3" href="KhoaHoc.php">
					<img width="200px" height="60px" src="assets/image/logoA.png">
	            </a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-inverse border-dark text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <i class="fas fa-bars"></i> -->
                <img src="./assets/image/menu.png">
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto" style="font-size: 18px;">
                	<?php if (isset($_SESSION['idKH']) || isset($_GET['idKH'])) {?>
                	<li class="nav-item dropdown">
					  <a class="text-nav nav-link active py-3 px-0 px-lg-3 rounded text-white" href="LuyenTap.php"><img class="p-1" src="assets/image/stack.png">Luyện tập</a>
					</li>
				<?php } ?>

			    	<li class="nav-item dropdown">
					  <a class="text-nav nav-link active py-3 px-0 px-lg-3 rounded text-white" href="KhoaHoc.php"><img class="p-1" src="assets/image/stack.png">Khóa học</a>
					</li>

				<?php 
						$row = selectTK($_SESSION['user']);				//	90
					?>


					<li class="nav-item dropdown" style="margin-right: 24px; min-width: 200px;">
					  <a class="text-nav nav-link dropdown-toggle active py-3 px-0 px-lg-3 rounded text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					    <?php 
					    	echo "<img class='p-1' src='assets/image/user.png'>" .$row['ten_hien_thi'];
					    ?>
					  </a>
					  <ul class="dropdown-menu" style="position: absolute;left: 20px;" aria-labelledby="navbarDropdownMenuLink">
				  	<?php if ($_SESSION['doiTuong'] == 2) { ?>
				  		<li><a class="text-nav dropdown-item py-2" href="QuanLyTaiKhoan.php">Quản lý tài khoản</a></li>
				  		
					<?php } 
						if ($_SESSION['doiTuong'] != 0) {
					?>
					  	<li><a class="text-nav dropdown-item py-2" href="TaoTaiKhoan.php">Tạo tài khoản</a></li>
				    <?php } ?>
					  	<li><a class="text-nav dropdown-item py-2" href="ThongTinCaNhan.php">Thông tin cá nhân</a></li>
					  	<li><a class="text-nav dropdown-item py-2" href="DoiMatKhau.php">Đổi mật khẩu</a></li>
					    <li><a class="text-nav dropdown-item py-2" href="DangXuat.php">Đăng xuất</a></li>
					  </ul>
					</li>

				<?php 
					// }; 
				?>
				</ul>


            </div>
        </div>
    </nav>

<?php 
	// function 
?>