<?php include '../header.php';
?>
<div class="page-content">
    <div class="container">
        <br />
        <?php

        if (isset($_GET['survey_id'])) {
            $survey_id = $_GET['survey_id'];
            $stringSQL = "select * from survey where survey_id=" . $survey_id . "";
            $dataSurvey = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
            $first_id = 0;
            $first_group = 0;
            ?>
        <form action="" method="POST">

            <!-- Title -->
            <div class="form-group" style='position:relative;'>
                <div class="col-xs-12">
                    <div class="introduce">
                        <?php
                        if (!$dataSurvey) echo "Không có dữ liệu!";
                        else {
                            ?>
                        <h2 name="survey_title" class="" id="survey_title">
                            <?php echo $dataSurvey['survey_title'];
                            if (is_admin()) {
                                $survey_vote = $dataSurvey['vote'];
                                $survey_score = $dataSurvey['score'];
                                echo " ({$survey_vote} vote,{$survey_score} điểm)";
                            }

                            ?></h2>

                        <?php
                        if (is_admin()) {

                            ?>
                        <a href="<?php echo $baseurl; ?>/survey/edit.php?survey_id=<?php echo $survey_id; ?>" class='btn btn-primary'>Sửa</a>
                        <button id="delete_survey" type="button" class='btn btn-danger'>Xóa</button>
                        <?php

                    }
                    ?>
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
                        if ($first_group < 1)  $first_group = $id_group;
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

                                        if ($first_id < 1)  $first_id = $id_question;
                                        $question_count++;
                                        $stringSQL = "select * from survey_questions where question_id=" . $id_question;
                                        $dataQuestion = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                                        $last_id_question = $id_question;

                                        $vote_number = (!$dataQuestion['vote']) ? 0 : $dataQuestion['vote'];
                                        $score = (!$dataQuestion['score']) ? 0 : $dataQuestion['score'];
                                        ?>

                                <tr>


                                    <td class="questions">
                                        <p id="comment-<?php echo $id_question; ?>"><?php echo $dataQuestion['question_title'];

                                                                                    if (is_admin()) {
                                                                                        echo " (" . $vote_number . " vote," . $score . " điểm)";
                                                                                    }
                                                                                    ?></p>
                                        <input type="text" name="question_title_<?php echo $id_question; ?>" value="value" style="display:none" />
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
                                                <input type="radio" name="score_<?php echo $id_question; ?>" id="four_<?php echo $id_question; ?>" value="4" class="hidden" />
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
                            <span>Ý kiến riêng : <span>
                                    <textarea name="custom_vote[]" class="form-control" rows="5" id="commentss-<?php echo $id_group; ?>"></textarea>
                                    <div class="sub-vote">
                                        <?php
                                    // Admin view
                                        if (is_admin()) {
                                            if (isset($dataGroup['custom_vote'])) {
                                                echo "<b style='color:red'>Ý kiến của người dùng: </b> <br />";
                                                $array_custom = explode("-pqt-", $dataGroup['custom_vote']);

                                                foreach ($array_custom as $custom_content) {
                                                    if ($custom_content != "")  echo "<li>" . $custom_content . "</li>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    </div>
                                    <style>
                                    .sub-vote li:after{
                                        content: ""!important;
                                    }
                                    </style>
                                    
                        </div>
                    </div>
                </div>
                <?php

            }
        }
        if ($dataSurvey) {
            ?>

                <button class='btn btn-primary pqt-btn full' name='submit' type='submit'>Gửi</button>
                <div class="center">
                </div>
                <?php

            }
        }
        ?>


        </form>
    </div>

</div>
</div>
<script>
    var local_survey_id = <?php echo $survey_id ?>;
    $(document).ready(function() {
        $("#delete_survey").click(function() {
            var cf = confirm("Bạn có chắc muốn xóa?");
            var this_url = window.location.href;
            if (cf != true) return;
            else {
                $.ajax({
                    url: "../survey/delete.php",
                    type: "POST",
                    data: {
                        id: local_survey_id
                    },
                    success: function(data) {
                        document.location.href = this_url;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Error!", "Lỗi khi xóa, hãy thử lại sau!", "error");
                    }
                });
            }


        });
    });
</script>
<?php include '../footer.php' ?>




<?php
if (isset($_POST['submit'])) {
    $item = $first_id;
    $group = $first_group;
    $local_score = 100;
    $question_number = array_values($_POST['question_number']);
    $custom_vote = array_values($_POST['custom_vote']);
    foreach ($question_number as $key => $value) {
        // Vote Question, Score
        for ($i = 0; $i < $value; $i++) {

            while (!isset($_POST["question_title_$item"])) {
                $item++;
            }
            $stringSQL = "select * from survey_questions where question_id=" . $item . "";
            $query = mysqli_query($conn, $stringSQL);

            if (!$query) {
                echo '<script>swal("Lỗi !!!", "Lỗi khi truy xuất dữ liệu Questions : ' . mysqli_error($conn) . '", "error"); </script>';
                exit;
            } else {
                $question_data = mysqli_fetch_array($query);
                $get_score = (floatval($_POST["score_$item"]) * 100) / 4;
                if (!$get_score) {
                    echo '<script>swal("Lỗi !!!", "Vui lòng chọn 1 trong 4 ô, không được để trống.", "error"); </script>';
                    exit;
                }
                $score_question = (!isset($question_data['score']) || $question_data['score'] == null) ? 100 : $question_data['score'];
                $vote_question = (!isset($question_data['vote']) || $question_data['vote'] == null) ? 0 : $question_data['vote'];
                $score_question = (float)($score_question + $get_score) / 2;
                $vote_question++;


                // print_r($score_question);
                // exit;
                $local_score = ($local_score + $score_question) / 2;


                $stringSQL = "update survey_questions set vote=" . intval($vote_question) . ", score=" . floatval($score_question) . " where question_id=" . $item . "";
                $query = mysqli_query($conn, $stringSQL);
                if (!$query) {
                    echo '<script>swal("Lỗi !!!", "Lỗi khi gửi yêu cầu: ' . mysqli_error($conn) . '", "error"); </script>';
                    exit;
                }
            }
            $item++;
        }

        // Custom vote
        // while (!isset($_POST["custom_vote_$group"])) {
        //     if (trim($_POST["custom_vote_$group"]) == "") {
        //         $group++;
        //         continue;
        //     }
        // }
        $vote_content = $custom_vote[$key];
        $stringSQL = "update survey_groups set custom_vote = if(custom_vote is null, CONCAT('','" . $vote_content . "-pqt-') , CONCAT(custom_vote,'" . $vote_content . "-pqt-')) where group_id=" . $group . "";
        $query = mysqli_query($conn, $stringSQL);
        if (!$query) {
            echo '<script>swal("Lỗi !!!", "Lỗi khi gửi yêu cầu: ' . mysqli_error($conn) . '", "error"); </script>';
            exit;
        }

        $stringSQL = "update survey set vote = vote + 1, score=" . $local_score . " where survey_id=" . $survey_id . "";
        $query = mysqli_query($conn, $stringSQL);
        if (!$query) {
            echo '<script>swal("Lỗi !!!", "Lỗi khi gửi yêu cầu: ' . mysqli_error($conn) . '", "error"); </script>';
            exit;
        }


        echo '<script>var this_url = window.location.href;
        
        swal({title:"Done!!!",text: "Gửi yêu cầu thành công :)", type:"success"},function(){window.location.href= this_url;}); </script>';
        // echo '<meta http-equiv="refresh" content="0">';
    }
}
?> 