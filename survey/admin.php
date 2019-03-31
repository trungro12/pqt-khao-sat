<?php include '../header.php';
pqt_permission();
?>


<div class="page-content">
<div class="introduce">
<h2>Survey Control Panel</h2>
</div>
    <a class='btn btn-success pqt-btn' href="<?php echo $baseurl; ?>/survey/add.php">Tạo khảo sát mới</a>
    <div class="container">
        <div class="row survey-content">
            <?php
            $stringSQL = "select * from survey";
            $query = mysqli_query($conn, $stringSQL);
            while ($data = mysqli_fetch_array($query)) {
                    ?>

            <div class="col-xs-6 col-md-3 text-center item" id="survey-<?php echo $data['survey_id'];?>" >
                <a href="<?php echo $baseurl; ?>/survey/view.php?survey_id=<?php echo $data['survey_id']; ?>">
                    <img src="<?php echo $baseurl; ?>/images/survey-icon-blue.png" alt="#">
                    <p class='survey-name'><?php echo $data['survey_title'];?></p>
                </a>
                <a href="<?php echo $baseurl; ?>/survey/edit.php?survey_id=<?php echo $data['survey_id'];?>" class='btn btn-info'>Sửa</a>
                <a href="<?php echo $baseurl; ?>/survey/view.php?survey_id=<?php echo $data['survey_id'];?>" class='btn btn-primary'>Xem</a>
                <button onclick="delete_survey(<?php echo $data['survey_id'];?>)" class='btn btn-danger'>Xóa</button>
            </div>


            <?php
        }
    ?>

        </div>
    </div>
</div>


<?php include '../footer.php' ?> 