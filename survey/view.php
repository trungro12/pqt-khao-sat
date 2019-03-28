<?php include '../header.php';
?>
<div class="page-content">
    <div class="container">
        <br />
        <form action="" method="POST">
            <?php

            if (isset($_GET['survey_id'])) {
                $survey_id = $_GET['survey_id'];
                $stringSQL = "select * from survey where survey_id=" . $survey_id . "";
                $dataSurvey = mysqli_fetch_array(mysqli_query($conn, $stringSQL));

                ?>
            <div class="form-group" style='position:relative;'>
                <div class="col-xs-12">
                    <h2 name="survey_title" class="" id="survey_title"> <?php echo "wewe" . $dataSurvey['survey_title'] ?></h2>
                </div>
            </div>
            <div class="survey-content">
                <?php 
                $array_group = explode("-pqt-", $dataSurvey['survey_group']);
                foreach ($array_group as $id_group) {
                    if ($id_group != "" || $id_group != null) {
                        $stringSQL = "select * from survey_groups where group_id=" . $id_group;
                        $dataGroup = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                        $last_id_group = $id_group;
                        ?>
                <div id='fgroup-<?php echo $id_group; ?>'>
                    <div class="group">
                        <div class="group-title">
                            <span>
                                <div class="col-xs-4">
                                    <h3 name="group_title_<?php echo $id_group; ?>" class="form-control" id="ex<?php echo $id_group; ?>" type="text"><?php echo $dataGroup['group_title']; ?></h3>
                                </div>
                            </span>
                        </div>
                        <div class="group-content">
                            <!-- List Question -->
                            <ul>
                            <?php
                            $question_count = 0;
                            $array_question = explode("-pqt-", $dataGroup['group_question']);
                            foreach ($array_question as $id_question) {

                                if ($id_question != "" || $id_question != null) {
                                    $question_count++;
                                    $stringSQL = "select * from survey_questions where question_id=" . $id_question;
                                    $dataQuestion = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                                    $last_id_question = $id_question;
                                    ?>
                         
                              
                                        <li><p name="question_title_<?php echo $id_question; ?>" id="comment-<?php echo $id_question; ?>"><?php echo $dataQuestion['question_title']; ?></p></li>
                              
                          


                            <?php

                        }
                    }
                    ?>
                            </ul>
                          
                            <input type="hidden" id="question_number-<?php echo $id_group; ?>" name="question_number[]" value="<?php echo $question_count; ?>">

                            <span>Cho phép người dùng thêm ý kiến<span>
                                    <div>
                                        <input type="hidden" name="vote_<?php echo $id_group; ?>" value="<?php echo $dataGroup['vote']; ?>">
                                        <input value="1" name="vote_<?php echo $id_group; ?>" checked type="checkbox" id="cbx" style="display:none" />
                                        <label for="cbx" class="toggle">
                                            <span>
                                                <svg width="10px" height="10px" viewBox="0 0 10 10">
                                                    <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                                                </svg>
                                            </span>
                                        </label>
                                    </div>
                        </div>
                    </div>
                </div>
                <?php

            }
        }
    }
    ?>
        </form>
    </div>

</div>
</div>

<?php include '../footer.php' ?>




<?php

?> 