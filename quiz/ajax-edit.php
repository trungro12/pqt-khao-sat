<?php
include '../db/connect.php';
        if (isset($_GET['survey_id'])) {
            $idsurvey = $_GET['survey_id'];
            $stringSQL = "select * from survey where survey_id=" . $idsurvey;
            $dataSurvey = mysqli_fetch_array(mysqli_query($conn, $stringSQL));

            $last_id_group = 0;
            $last_id_question = 0;
            ?>


        <!-- <form action="" method="POST"> -->

        <div class="introduce">
            <div class="form-group" style='position:relative;'>
                <div class="col-xs-12">
                    <label for="survey_title" style='text-align:center;font-weight: bold;font-size: 25px;'>Tiêu đề khảo sát</label>
                    <input required value="<?php echo $dataSurvey['survey_title']; ?>" name="survey_title" class="form-control" id="survey_title" type="text">
                    <span id="update-survey"> </span>
                </div>
                <script>
                    $("#survey_title").on("change", function() {
                        var post = <?php echo $idsurvey; ?>;
                        var comment = $.trim($(this).val());
                        if (comment == "") {
                            swal("Error !!!", "Không được để trống !", "error");
                            return;
                        }
                        $.ajax({
                            type: "POST",
                            url: "../survey/mod-update-survey.php",
                            data: {
                                post: post,
                                comment: comment
                            },
                            success: function(data) {

                                $("#update-survey").html("<b style='color:#fff;'>Cập nhật thành công</b>");
                                setTimeout(() => {
                                    $("#update-survey").html("");
                                }, 1500);

                            }
                        });
                    });
                </script>
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
                <h3> Nhóm câu hỏi </h3>
                <div class="group">
                    <div class="group-title">
                        <span>
                            <div class="col-xs-4">
                                <label for="ex<?php echo $id_group; ?>">Tiêu đề nhóm câu khảo sát.</label>
                                <input required value="<?php echo $dataGroup['group_title']; ?>" name="group_title_<?php echo $id_group; ?>" class="form-control" id="ex<?php echo $id_group; ?>" type="text">
                                <span id="update-ex<?php echo $id_group; ?>"> </span>
                            </div>
                            <script>
                                $("#ex<?php echo $id_group; ?>").on("change", function() {
                                    var post = <?php echo $id_group; ?>;
                                    var comment = $.trim($(this).val());
                                    if (comment == "") {
                                        swal("Error !!!", "Không được để trống !", "error");
                                        return;
                                    }
                                    $.ajax({
                                        type: "POST",
                                        url: "../survey/mod-update-group.php",
                                        data: {
                                            post: post,
                                            comment: comment
                                        },
                                        success: function(data) {

                                            $("#update-ex<?php echo $id_group; ?>").html("<b>Cập nhật thành công</b>");
                                            setTimeout(() => {
                                                $("#update-ex<?php echo $id_group; ?>").html("");
                                            }, 1500);

                                        }
                                    });
                                });
                                $("#update-ex<?php echo $id_group; ?>").css("color", "#fff");
                            </script>
                        </span>
                        <span> <button type="button" onclick="delete_group(<?php echo $id_group; ?>)" class='btn btn-danger delete-group'>Xóa nhóm này</button></span>
                    </div>
                    <div class="group-content">
                        <!-- List Question -->
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
                        <div class="form-group" style='position:relative;'>
                            <div id="fquestion-<?php echo $id_question; ?>">
                                <div class="box-question">
                                    <label for="comment-<?php echo $id_question; ?>">Nội dung câu hỏi:</label>
                                    <span> <button type='button' onclick="delete_question(<?php echo $id_question; ?>,<?php echo $id_group; ?>)" class='btn btn-danger delete-group'>Xóa câu này</button></span>
                                    <textarea required name="question_title_<?php echo $id_question; ?>" class="form-control" rows="5" id="comment-<?php echo $id_question; ?>"><?php echo $dataQuestion['question_title']; ?></textarea>
                                    <span id="update-comment-<?php echo $id_question; ?>"> </span>
                                    <script>
                                        $("#comment-<?php echo $id_question; ?>").on("change", function() {
                                            var post = <?php echo $id_question; ?>;
                                            var comment = $.trim($(this).val());
                                            if (comment == "") {
                                                swal("Error !!!", "Không được để trống !", "error");
                                                return;
                                            }
                                            $.ajax({
                                                type: "POST",
                                                url: "../survey/mod-update-question.php",
                                                data: {
                                                    post: post,
                                                    comment: comment
                                                },
                                                success: function(data) {

                                                    $("#update-comment-<?php echo $id_question; ?>").html("<b style='color:red;'>Cập nhật thành công</b>");
                                                    setTimeout(() => {
                                                        $("#update-comment-<?php echo $id_question; ?>").html("");
                                                    }, 1500);

                                                }
                                            });
                                        });
                                        $("#update-ex<?php echo $id_group; ?>").css("color", "#fff");
                                    </script>
                                </div>
                            </div>
                        </div>


                        <?php

                    }
                }
                ?>
                        <div id='show_question-<?php echo $id_group; ?>'></div>
                        <input type="hidden" id="question_number-<?php echo $id_group; ?>" name="question_number[]" value="<?php echo $question_count; ?>">
                        <button type='button' class='btn btn-primary pqt-btn full' onclick='add_question(<?php echo $id_group; ?>);'>Thêm câu hỏi mới</button>

                        <span>Cho phép người dùng thêm ý kiến<span>
                                <div>
                                    <input type="hidden" name="vote_<?php echo $id_group; ?>" value="0">

                                    <input value="<?php echo $dataGroup['vote']; ?>" name="vote_<?php echo $id_group; ?>" type="checkbox" id="cbx-<?php echo $id_group; ?>" style="display:none" />

                                    <label for="cbx-<?php echo $id_group; ?>" class="toggle">
                                        <span>
                                            <svg width="10px" height="10px" viewBox="0 0 10 10">
                                                <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                                            </svg>
                                        </span>
                                    </label>
                                </div>
                                <?php if ($dataGroup['vote'] == 1) echo '<script> 
                                        $("#cbx-' . $id_group . '").prop( "checked", true );
                                        </script>'; ?>

                                <script>
                                    $("#cbx-<?php echo $id_group; ?>").on("change", function() {
                                        var post = <?php echo $id_group; ?>;
                                        var apply = $(this).is(':checked') ? 1 : 0;

                                        $.ajax({
                                            type: "POST",
                                            url: "../survey/mod-update-checkbox.php",
                                            data: {
                                                post: post,
                                                apply: apply
                                            },
                                            success: function(data) {

                                                swal("Done !!!", "Cập nhật thành công!", "success");

                                            }
                                        });
                                    });
                                </script>

                                <?php
                                echo "
                                    <style>
                                    #cbx-" . $id_group . ":checked+.toggle:before {
                                        background: #52d66b;
                                    }

                                    #cbx-" . $id_group . ":checked+.toggle span {
                                        transform: translateX(18px);
                                    }

                                    #cbx-" . $id_group . ":checked+.toggle span path {
                                        stroke: #52d66b;
                                        stroke-dasharray: 25;
                                        stroke-dashoffset: 25;
                                    } </style>";
                                ?>

                    </div>
                </div>
            </div>
            <?php

        }
    }
    ?>

            <div id='show_group'></div>
            <button type='button' class='btn btn-success pqt-btn full' id='add_group' href="#">Thêm nhóm câu hỏi mới</button>
            <br />
            <!-- <button class='btn btn-primary pqt-btn full' name='submit' type='submit'>Lưu</button> -->
            <!-- </form> -->
            <?php

        } else echo '<script> swal("Lỗi !!!", "Đường dẫn sai hoặc không tồn tại!!!", "error");  </script>';
        ?>