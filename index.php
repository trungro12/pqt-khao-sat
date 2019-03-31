<?php include 'header.php' ?>
<div class="introduce">
    <h3>Phần mềm khảo sát và trắc nghiệm miễn phí</h3>
    <p class='des'>Một phần mềm giúp thu thập, đánh giá chất lượng, ý kiến của từng người trong một tập thể. Từ những
        ý kiến đó góp phần làm cho tập thể phát triển hơn.
    </p>
</div>
<div class="page-content">
    <div class="container">
        <span style="text-align: center;display: block;"><a class='button_css' href="<?php echo $baseurl; ?>/quiz/">Trắc ngiệm</a><a class='button_css' href="<?php echo $baseurl; ?>/survey/">Khảo sát</a></span>
        <div class="row survey-content">
            <?php
            $stringSQL = "select * from survey";
            $query = mysqli_query($conn, $stringSQL);
            while ($data = mysqli_fetch_array($query)) {
                ?>

            <div class="col-xs-6 col-md-3 text-center item" id="survey-<?php echo $data['survey_id']; ?>">
                <a href="<?php echo $baseurl; ?>/survey/view.php?survey_id=<?php echo $data['survey_id']; ?>">
                    <img src="<?php echo $baseurl; ?>/images/survey-icon-blue.png" alt="#">
                    <p class='survey-name'><?php echo $data['survey_title']; ?></p>
                </a>
                <?php
                if (is_admin()) {
                        ?>
                <a href="<?php echo $baseurl; ?>/survey/edit.php?survey_id=<?php echo $data['survey_id']; ?>" class='btn btn-info'>Sửa</a>
                <a href="<?php echo $baseurl; ?>/survey/view.php?survey_id=<?php echo $data['survey_id']; ?>" class='btn btn-primary'>Xem</a>
                <button onclick="delete_survey(<?php echo $data['survey_id']; ?>)" class='btn btn-danger'>Xóa</button>
                <?php

            }

        ?>
            </div>


            <?php

        }
        ?>

        </div>
    </div>
</div>


<?php include 'footer.php' ?> 