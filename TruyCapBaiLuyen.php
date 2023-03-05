<?php 
	include "Connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bài Luyện tập</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/cssX/check.css">
    <style type="text/css">
        .check{
            background: #6EE76E;
            padding: 16px;
            margin-top: 0px;
            text-align: center;
            animation: modalFadeIn 0.5s;
        }

        .check_error{
            background: pink !important;
        }

        @keyframes modalFadeIn{
            from{
                transform: translateY(-50px);
            }
            to{
                transform: translateY(0px);
            }
        }

        fieldset{
            background-color: #eeeeee;
            padding: 3rem 2rem;
        }

        legend {
          background-color: gray;
          color: white;
          padding: 5px 10px;
        }
    </style>
</head>
<body>
    <main style="min-height: 90vh; max-width: 100%;">

    	<?php 
            include "navbar.php"; 
            $idBL = $_GET['idBL'];
        ?>

    	<div style="height: 86px;"></div>

        <!-- Nộp Bài -->

        <?php 

            function dapAn($id){
                GLOBAL $conn;
                $sql = "SELECT dap_an FROM tb_cau_hoi WHERE id = $id";
                $query = mysqli_query($conn, $sql);
                return mysqli_fetch_array($query)['0'];
            }

            function getCountSL($idBL){
                GLOBAL $conn;
                $sql = "SELECT COUNT(id) AS num FROM tb_cau_hoi WHERE id_bai_luyen_tap = $idBL";
                $query = mysqli_query($conn, $sql);
                return mysqli_fetch_array($query)['0'];
            }


            if (isset($_POST['NopBai'])) {
                $sl = getCountSL($idBL);
                $dem = 0;                    //số câu đúng
                if (isset($_POST['arrBL'])) {
                     $arrBL = $_POST['arrBL'];
                     foreach ($arrBL as $key => $value) {
                        $da = dapAn($key);
                        if ($da == $value) {
                            $dem += 1;
                        }
                    }
                 } else $dem = 0; 

                $diem = (float)($dem / $sl) * 10;
            }
        ?>

        <!-- Chua xong -->

        <?php 
            $sql = "SELECT * FROM tb_cau_hoi WHERE id_bai_luyen_tap = $idBL";
            $query = mysqli_query($conn, $sql);
        ?>

    	<div class="d-flex justify-content-center mt-5">
    
        <form action="" method="POST" class="w-75">
            <fieldset>
                <legend>Luyện Tập</legend>
                <!-- <h3 class="mb-3 text-center">Câu hỏi luyện tập</h3> -->

                <!-- Begin Câu hỏi -->
                <?php while ($row = mysqli_fetch_array($query)) { ?>
                <div class="mb-3 h5" >
                  <?php echo $row['ten_cau_hoi']; ?>
                </div>
                <div class="mb-3" style="margin-left: 16px;">
                  <input type="radio" <?php if (isset($_POST['NopBai'])) {
                      echo "disabled";
                  } ?> 
                  id="<?php echo $row['id']; ?>" 
                  name="arrBL[<?php echo $row['id']; ?>]" 
                  <?php if (isset($arrBL[$row['id']]) && $arrBL[$row['id']] == "A") {
                      echo "checked";
                  } ?> value="A">
                  A: <?php echo $row['da_A']; ?>
                </div>

                <div class="mb-3" style="margin-left: 16px;">
                  <input type="radio" <?php if (isset($_POST['NopBai'])) {
                      echo "disabled";
                  } ?> 
                  id="<?php echo $row['id']; ?>" 
                  name="arrBL[<?php echo $row['id']; ?>]" 
                  <?php if (isset($arrBL[$row['id']]) && $arrBL[$row['id']] == "B") {
                      echo "checked";
                  } ?> value="B">
                    B: <?php echo $row['da_B']; ?>
                </div>

                <div class="mb-3" style="margin-left: 16px;">
                  <input type="radio" <?php if (isset($_POST['NopBai'])) {
                      echo "disabled";
                  } ?> 
                  id="<?php echo $row['id']; ?>" 
                  name="arrBL[<?php echo $row['id']; ?>]" 
                  <?php if (isset($arrBL[$row['id']]) && $arrBL[$row['id']] == "C") {
                      echo "checked";
                  } ?> value="C">
                    C: <?php echo $row['da_C']; ?>
                </div>

                <div class="mb-3" style="margin-left: 16px;">
                  <input type="radio" <?php if (isset($_POST['NopBai'])) {
                      echo "disabled";
                  } ?> 
                  id="<?php echo $row['id']; ?>" 
                  name="arrBL[<?php echo $row['id']; ?>]" 
                  <?php if (isset($arrBL[$row['id']]) && $arrBL[$row['id']] == "D") {
                      echo "checked";
                  } ?> value="D">
                    D: <?php echo $row['da_D']; ?>
                </div>

                <?php if (isset($_POST['NopBai'])) { ?>
                <div class="mb-3 p-2 bg-primary text-white h4">
                    Đáp án: <?php 
                        echo dapAn($row['id']);
                    ?>
                </div>

            <?php } ?>

                <!-- END Câu hỏi -->


                <?php if ($_SESSION['doiTuong'] != 0) { 
                ?>
                <a class="btn btn-warning mb-3" href="SuaCauHoi.php?idBL=<?php echo $idBL .'&id=' .$row['id'];?>">Sửa Câu Hỏi</a>
            <?php }} ?>


    <!-- ĐIỂM -->
            <?php if (isset($_POST['NopBai'])) { ?>
            <div class="text-center h3 bg-info p-2">
                Điểm:  <?php echo round($diem, 2) ; ?>
            </div>
             <?php } ?>

            <br><br>

                <?php if ($_SESSION['doiTuong'] != 0) {
                    
                ?>
                <a class="btn btn-success" href="ThemCauHoi.php?idBL=<?php echo $idBL; ?>">Thêm Câu Hỏi</a>

            <?php } ?>
                <input type="submit" class="btn btn-success" name="NopBai" value="Nộp bài">
                <a class="btn btn-success" href="TruyCapBaiLuyen.php?idBL=<?php echo $idBL; ?>">Làm lại</a>
                <a class="btn btn-success" href="LuyenTap.php?idBL=<?php echo $idBL; ?>">Trở lại</a>
            </fieldset>
        </form>
        <br> <br>
        </div>

        <!-- <form action="ggg">
            <fieldset>
                <legend>Bài Luyện Tập</legend>
                <lable>Full Name: </lable>
                <input type="text" name="fullname" placeholder="Enter full name">
                <label>Gender</label>
                <input type="radio" name="gender" id="" checked value="male">
                <input type="radio" name="gender" id="" value="female">
            </fieldset>
        </form> -->
	</main>
    <?php include "footer.php"; ?>
</body>
</html>


