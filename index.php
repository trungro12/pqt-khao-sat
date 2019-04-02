<?php include 'header.php' ?>
<div class="introduce">
    <h3>Phần mềm khảo sát và trắc nghiệm miễn phí</h3>
    <p class='des'>Một phần mềm giúp thu thập, đánh giá chất lượng, ý kiến của từng người trong một tập thể. Từ những
        ý kiến đó góp phần làm cho tập thể phát triển hơn.
    </p>
</div>
<div class="page-content">
    <div class="container">
        <span style="text-align: center;display: block;"><a class='button_css' href="<?php echo $baseurl; ?>/index.php?only_quiz=1">Trắc ngiệm</a><a class='button_css' href="<?php echo $baseurl; ?>/index.php?only_survey=1">Khảo sát</a></span>

        <div id="survey_show">

            <!-- Navigation -->
            <?php
            $result = mysqli_query($conn, 'select count(survey_id) as total from survey');
            $row = mysqli_fetch_assoc($result);
            $total_records = $row['total'];

            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = 10;

            $total_page = ceil($total_records / $limit);

            if ($current_page > $total_page) {
                $current_page = $total_page;
            } else if ($current_page < 1) {
                $current_page = 1;
            }

            $start = ($current_page - 1) * $limit;

            $result = mysqli_query($conn, "select * FROM survey LIMIT $start, $limit");

            ?>




            <span style="font-size: 26px;
    font-weight: bold;
    text-align: center;
    margin: auto;
    display: block;
    padding: 1;">Khảo sát mới nhất</span>
            <div class="row survey-content">

                <?php
                while ($data = mysqli_fetch_array($result)) {
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
            <br />


        </div>
        <div id="survey_nav" style="text-align: center;
    display: block!important;
    margin: auto;" class="pagination">
            <?php 


            if ($current_page > 1 && $total_page > 1) {
                echo '<a href="index.php?page=' . ($current_page - 1) . '?only_survey=1">Prev</a> | ';
            }


            for ($i = 1; $i <= $total_page; $i++) {

                if ($i == $current_page) {
                    echo '<span class="button_css">' . $i . '</span>  ';
                } else {
                    echo '<a href="index.php?page=' . $i . '">' . $i . '?only_survey=1</a> | ';
                }
            }


            if ($current_page < $total_page && $total_page > 1) {
                echo '<a href="index.php?page=' . ($current_page + 1) . '?only_survey=1">Next</a> | ';
            }
            ?>
        </div>
        <!-- end  Navigation -->


        <div id="quiz_show">

            <!-- Quizzzzzzzzzzzzzzzzzzzzzzzzzzzzz -->
            <!-- Navigation -->
            <?php
            $result = mysqli_query($conn, 'select count(quiz_id) as total from quiz where public = 1');
            $row = mysqli_fetch_assoc($result);
            $total_records = $row['total'];

            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = 10;

            $total_page = ceil($total_records / $limit);

            if ($current_page > $total_page) {
                $current_page = $total_page;
            } else if ($current_page < 1) {
                $current_page = 1;
            }

            $start = ($current_page - 1) * $limit;

            $result = mysqli_query($conn, "select * FROM quiz where public = 1 LIMIT $start, $limit");

            ?>

            <!-- end  Navigation -->


            <span style="font-size: 26px;
    font-weight: bold;
    text-align: center;
    margin: auto;
    display: block;
    padding: 1;">Trắc nghiệm mới nhất</span>
            <div class="row survey-content">

                <?php
                while ($data = mysqli_fetch_array($result)) {
                    ?>

                <div class="col-xs-6 col-md-3 text-center item" id="quiz-<?php echo $data['quiz_id']; ?>">
                    <a href="<?php echo $baseurl; ?>/quiz/view.php?quiz_id=<?php echo $data['quiz_id']; ?>">
                        <img src="<?php echo $baseurl; ?>/images/survey-icon-blue.png" alt="#">
                        <p class='quiz-name'><?php echo $data['quiz_title'] . " (" . $data['time'] . " phút)"; ?></p>
                    </a>
                    <?php
                    if (is_admin()) {
                        ?>
                    <a href="<?php echo $baseurl; ?>/quiz/edit.php?quiz_id=<?php echo $data['quiz_id']; ?>" class='btn btn-info'>Sửa</a>
                    <a href="<?php echo $baseurl; ?>/quiz/view.php?quiz_id=<?php echo $data['quiz_id']; ?>" class='btn btn-primary'>Xem</a>
                    <button onclick="delete_quiz(<?php echo $data['quiz_id']; ?>)" class='btn btn-danger'>Xóa</button>
                    <?php

                }

                ?>
                </div>


                <?php

            }
            ?>

            </div>
        </div>
        <div id="quiz_nav" style="text-align: center;
    display: block!important;
    margin: auto;" class="pagination">
            <?php 


            if ($current_page > 1 && $total_page > 1) {
                echo '<a href="index.php?page=' . ($current_page - 1) . '?only_quiz=1">Prev</a> | ';
            }


            for ($i = 1; $i <= $total_page; $i++) {

                if ($i == $current_page) {
                    echo '<span class="button_css">' . $i . '</span>  ';
                } else {
                    echo '<a href="index.php?page=' . $i . '?only_quiz=1">' . $i . '</a> | ';
                }
            }


            if ($current_page < $total_page && $total_page > 1) {
                echo '<a href="index.php?page=' . ($current_page + 1) . '?only_quiz=1">Next</a> | ';
            }
            ?>
        </div>
        <!-- end  Navigation -->

    </div>
</div>
<?php
if(isset($_GET['only_survey']) && !isset($_GET['only_quiz']))
{
    echo '<script> $("#quiz_show").remove(); $("#quiz_nav").remove(); </script>';
}
else if(!isset($_GET['only_survey']) && isset($_GET['only_quiz']))
{
    echo '<script> $("#survey_show").remove(); $("#survey_nav").remove(); </script>';
}
?>

<?php include 'footer.php' ?> 