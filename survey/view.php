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
                $first_id = 0;
                ?>
            <!-- Title -->
            <div class="form-group" style='position:relative;'>
                <div class="col-xs-12">
                    <div class="introduce">
                        <?php
                        if (!$dataSurvey) echo "Không có dữ liệu!";
                        else {
                            ?>
                        <h2 name="survey_title" class="" id="survey_title"> <?php echo $dataSurvey['survey_title'] ?></h2>
                        <a href="<?php echo $baseurl; ?>/survey/edit.php?survey_id=<?php echo $survey_id; ?>" class='btn btn-info'>Sửa</a>
                        <button type='button' onclick="delete_survey(<?php echo $survey_id; ?>)" class='btn btn-danger'>Xóa</button>
                        <?php

                    }
                    ?>

                    </div>

                </div>
            </div>

            <!-- Content -->

            <div class="survey-content" style='display:block;'>
                <?php 
                $array_group = explode("-pqt-", $dataSurvey['survey_group']);
                foreach ($array_group as $id_group) {
                    if ($id_group != "" || $id_group != null) {
                        $stringSQL = "select * from survey_groups where group_id=" . $id_group;
                        $dataGroup = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                        $last_id_group = $id_group;
                        ?>
                        <br />
                <div id='fgroup-<?php echo $id_group; ?>'>
                    <div class="group">
                        <div class="group-title">
                            <span>
                                <div class="col-xs-4">
                                    <h3 name="group_title_<?php echo $id_group; ?>" id="ex<?php echo $id_group; ?>" type="text"><?php echo $dataGroup['group_title']; ?></h3>
                                </div>
                            </span>
                        </div>
                        <div class="group-content">
                            <!-- List Question -->
                            <table style='width:100%;'>


                                <tr>
                                    <th></th>
                                    <th>Không tốt</th>
                                    <th>Bình thường</th>
                                    <th>Khá tốt</th>
                                    <th>Rất tốt</th>

                                </tr>
                                <?php
                                $question_count = 0;
                                $array_question = explode("-pqt-", $dataGroup['group_question']);
                                foreach ($array_question as $id_question) {

                                    if ($id_question != "" || $id_question != null) {
                                       
                                        if($first_id <1 )  $first_id = $id_question;
                                        $question_count++;
                                        $stringSQL = "select * from survey_questions where question_id=" . $id_question;
                                        $dataQuestion = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                                        $last_id_question = $id_question;

                                        $vote_number = (!$dataQuestion['vote']) ? 0 : $dataQuestion['vote'];
                                        $score = (!$dataQuestion['score']) ? 0 : $dataQuestion['vote'];
                                        ?>

                                <tr>

                                        
                                    <td class="questions">
                                        <p name="question_title_<?php echo $id_question; ?>" id="comment-<?php echo $id_question; ?>"><?php echo $dataQuestion['question_title']." (".$vote_number." điểm,".$score." vote)"; ?></p>
                                    </td>
                                    <div class="cntr">
                                        <td>
                                            <label for="one_<?php echo $id_question; ?>" class="radio">
                                                <input type="radio" name="score_<?php echo $id_question; ?>" id="one_<?php echo $id_question; ?>" value="1" class="hidden" />
                                                <span class="label"></span>
                                            </label>
                                        </td>
                                        <!-- Radio -->
                                        <td>
                                            <label for="two_<?php echo $id_question; ?>" class="radio">
                                                <input type="radio" name="score_<?php echo $id_question; ?>" id="two_<?php echo $id_question; ?>" value="2" class="hidden" />
                                                <span class="label"></span>
                                            </label>
                                        </td>

                                        <td>

                                            <label for="three_<?php echo $id_question; ?>" class="radio">
                                                <input type="radio" name="score_<?php echo $id_question; ?>" id="three_<?php echo $id_question; ?>" value="3" class="hidden" />
                                                <span class="label"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <label for="four_<?php echo $id_question; ?>" class="radio">
                                                <input type="radio" name="score_<?php echo $id_question; ?>" id="four_<?php echo $id_question; ?>" required value="4" class="hidden" />
                                                <span class="label"></span>
                                            </label>

                                        </td>
                                    </div>
                                </tr>

                                <?php

                            }
                        }
                        ?>
                            </table>
                            <input type="hidden" id="question_number-<?php echo $id_group; ?>" name="question_number[]" value="<?php echo $question_count; ?>">


                            <?php
                            $is_vote = $dataGroup['vote'];
                           if ($is_vote == 1) {
                                ?>
                            <span>Ý kiến của bạn<span>
                                    <textarea name="custom_vote_<?php echo $id_group; ?>" class="form-control" rows="5" id="comment-<?php echo $id_group; ?>"></textarea>

                                    <?php

                                }
                                ?>

                        </div>
                    </div>
                </div>
                <?php

            }
        }
    }
    ?>
                <button class='btn btn-primary pqt-btn full' name='submit' type='submit'>Gửi</button>
                <div class="center">

                </div>

        </form>
    </div>

</div>
</div>

<?php include '../footer.php' ?>




<?php
if(isset($_POST['submit']))
{
    $item = $first_id;
    foreach($_POST['question_number'] as $value)
    {
        
    }
}   
?> 