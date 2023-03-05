<?php 
	include "Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Khóa Học</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
</head>
<body>
    <main style="min-height: 90vh; max-width: 100%;">

    	<?php 
            include "navbar.php"; 

            $_SESSION['idKH'] = $_GET['idKH'];

            if (isset($_GET['idKH'])) {
                $query = getQuery('tb_chu_de', 'id_khoa_hoc' , $_GET['idKH']);          //  110
            }else{
                header("location: KhoaHoc.php");
                die();
            }
        ?>

    	<div style="height: 86px;"></div>

        <div id="action" style="margin: 20px 0 0 2%;">
            <a href="KhoaHoc.php" class="btn btn-success">Trở lại</a>

        <?php 
            if ($_SESSION['doiTuong'] != 0) { 
        ?>
            <a href="ThemChuDe.php?idKH=<?php echo $_GET['idKH']; ?>" class="btn btn-success">Thêm chủ đề</a>
        <?php } ?>

        <a href="TaiLieuMonHoc.php?idTL=<?php echo $_GET['idKH']; ?>" class="btn btn-success">Tài liệu môn học</a>
        </div>

    	<div class="container w-75">


            <?php while ($rowCD = mysqli_fetch_array($query)) { 
                // $idCD = $rowCD['id'];
            ?>
            <div class="text-uppercase my-4">
                <a class="text-dark" style="text-decoration: none;" data-bs-toggle="collapse" style="font-weight: 700;" href="#collapseExample<?php echo $rowCD['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $rowCD['id']; ?>">


                    <!-- begin chủ đề-->
                    <div class="card" style="background: #DADADA;">
                        <div class="card-body">
                            <div class="h3">
                                <?php 
                                    echo $rowCD['ten_chu_de'];
                                    if ($_SESSION['doiTuong'] != 0) {
                                ?>
                                <a href="ThemBaiTap.php?idCD=<?php echo $rowCD['id']; ?>" class="btn btn-primary">Thêm bài tập</a>
                                <a href="SuaChuDe.php?idCD=<?php echo $rowCD['id']; ?>" class="btn btn-info">Sửa</a>
                                <form class="d-inline-block" method="POST" action="XoaChuDe.php?idCD=<?php echo $rowCD['id']; ?>" onsubmit="return confirmDelete()">
                                    <button class="btn btn-outline-danger" type="submit" name="btnXoa">Xóa</button>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end chủ đề-->


              </a>
            </div>
            <div class="collapse" id="collapseExample<?php echo $rowCD['id']; ?>">
                <ul style="list-style-type: none; padding: 0; margin: 0;">

                    <?php
                        $queryBT = getQuery('tb_bai_tap', 'id_chu_de' , $rowCD['id']);          //  110
                        while ($rowBT = mysqli_fetch_array($queryBT)) {
                    ?>


                    <!-- begin bài tập-->
                    <li class="my-2">
                        <div class="card" style="background: #F4F4F4;">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $rowBT['ten_bai_tap']; ?></h4>
                                <p>
                                    <div class="d-inline-block px-2 py-1 bg-success mb-2 text-white" style="border-radius: 30px;">Ngày mở: <?php echo $rowBT['ngay_mo']; ?></div>
                                    <div class="d-inline-block px-2 py-1 bg-success mb-2 text-white" style="border-radius: 30px;">Hạn nộp: <?php echo $rowBT['han_nop']; ?></div>
                                </p>

                                <p>
                                    <div class="d-inline-block px-2 py-1 mb-2" style="background: pink; border-radius: 30px; letter-spacing: -0.5px;">
                                        <?php  
                                            $hanNop = date_timestamp_get(date_create($rowBT['han_nop'], timezone_open("Asia/Ho_Chi_Minh"))); 
                                            $time = $hanNop - time();
                                            if ($time > 0) {
                                                $date_time = return_date_time($time);               //172 - function.php
                                                echo "Còn lại: " . $date_time;

                                            }else{
                                                echo "Hết hạn nộp bài";
                                            }
                                        ?>
                                    </div>

                                    <?php 
                                        $user = $_SESSION['user'];
                                        $idBT = $rowBT['id'];
                                        $sql = "SELECT id FROM tb_bai_nop 
                                                WHERE ten_tai_khoan = '$user' AND id_bai_tap = $idBT";
                                        $queryBN = mysqli_query($conn, $sql);
                                        $num = mysqli_num_rows($queryBN);
                                        if ($num == 1) {
                                    ?>
                                    <div class="d-inline-block px-2 py-1 bg-primary text-white mb-2" style="border-radius: 6px; float: right; box-shadow: 4px 4px 4px #749BD1;">
                                        <i class="ri-check-fill"></i> Đã hoàn thành
                                    </div>

                                    <?php
                                        }else { 
                                    ?>                                            
                                        <div class="d-inline-block px-2 py-1 bg-light border-dark border text-dark mb-2" style="border-radius: 6px; float: right; box-shadow: 4px 4px 4px #909090;">
                                            <i class="ri-check-fill"></i> Chưa hoàn thành
                                        </div>
                                    <?php
                                        };  
                                    ?>
                                    <div class="clearfix"></div>
                                </p>
                                <a href="ChiTietBaiTap.php?idBT=<?php echo $idBT; ?>" class="btn btn-primary">Chi Tiết</a>
                            <?php 
                                if ($_SESSION['doiTuong'] != 0) { 
                            ?>
                                <a href="SuaBaiTap.php?idBT=<?php echo $rowBT['id']; ?>" class="btn btn-info">Sửa</a>
                                <form class="d-inline-block" method="POST" action="XoaBaiTap.php?idBT=<?php echo $rowBT['id']; ?>" onsubmit="return confirmDeleteBT()">
                                    <button class="btn btn-outline-danger" type="submit" name="btnXoa">Xóa</button>
                                </form>
                                <a href="QuanLyBaiNop.php?idBT=<?php echo $rowBT['id']; ?>" class="btn btn-outline-warning">Quản lý bài nộp</a>

                            <?php } ?>
                            </div>
                        </div>
                    </li>
                    <!-- end bài tập-->


                <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
	</main>
    <?php include "footer.php"; ?>
</body>
</html>


<script type="text/javascript">
    function confirmDelete(){
       if(confirm("Xóa chủ đề? "))
         return true;
      
      return false;
    }

    function confirmDeleteBT(){
       if(confirm("Xóa bài tập? "))
         return true;
      
      return false;
    }
    </script>


