<?php include '../header.php';
pqt_permission();
?>
<div class="page-content">
    <div class="container" id="full-page">
        <br />
        <?php
        if (isset($_GET['survey_id'])) {
            $survey_id = $_GET['survey_id'];
            $stringSQL = "select * from survey where survey_id=" . $survey_id;
            $dataSurvey = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
            if(!$dataSurvey)
            {
                echo '<script> swal("Lỗi !!!", "Đường dẫn sai hoặc không tồn tại!!!", "error");  </script>';
                exit;
            }
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
                <br />
                <?php
                        if(is_admin())
                        {

                        ?>
                        <a href="<?php echo $baseurl; ?>/survey/view.php?survey_id=<?php echo $survey_id; ?>" class='btn btn-primary'>Xem</a>
                        <?php
}
                        ?>
                <script>
                    $("#survey_title").on("change", function() {
                        var post = <?php echo $survey_id; ?>;
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
                                $("#update-ex<?php echo $id_group; ?>").css("color","#fff");
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

                                                    $("#update-comment-<?php echo $id_question; ?>").html("<b>Cập nhật thành công</b>");
                                                    setTimeout(() => {
                                                        $("#update-comment-<?php echo $id_question; ?>").html("");
                                                    }, 1500);

                                                }
                                            });
                                        });
                                        $("#update-comment-<?php echo $id_question; ?>").css("color","red");
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
        </div>

    </div>
</div>
<script>
    var local_survey_id = <?php echo $survey_id ?>;
    $("#delete_survey").click(function() {
        var cf = confirm("Bạn có chắc muốn xóa?");
        if (cf != true) return;
        else {
            var this_url = window.location.href;
            $(".page-content").css("display","none");
            $.ajax({
                url: "../survey/delete.php",
                type: "POST",
                data: {
                    id: local_survey_id
                },
                success: function(data) {
                 
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error!", "Lỗi khi xóa, hãy thử lại sau!", "error");
                }
            });
        }


    });
</script>
<?php include '../footer.php' ?>

<script>
    // Add, Delete Group 
    var id_group = <?php echo $last_id_group ?>;
    var id_question = <?php echo $last_id_question ?>;
    var idsurvey = <?php echo $survey_id ?>;
    $("#add_group").click(function() {

        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/survey/mod-add-group.php",
            data: {
                idsurvey: idsurvey
            },
            dataType: "json",
            success: function(data) {
                id_group = data.id_groups;
                id_question = data.id_questions;
                console.log(data);
                $('<div id="fgroup-' + id_group + '"><br /><h3> Nhóm câu hỏi </h3><div class="group">  <div class="group-title">  <span>    <div class="col-xs-4"> <label for="ex' + id_group + '">Tiêu đề nhóm câu khảo sát.</label> <input class="form-control" required name="group_title[]" id="ex' + id_group + '" type="text"> <span id="update-ex' + id_group + '"> </span> </div>  </span> <span> <button class="btn btn-danger delete-group" onclick="delete_group(' + id_group + ')" >Xóa nhóm này</button></span> </div> <script> $("#ex' + id_group + '").on("change", function() { var post = ' + id_group + ';   var comment = $.trim($(this).val()); if (comment == "") {   swal("Error !!!", "Không được để trống !", "error");   return; }       $.ajax({     type: "POST",      url: "../survey/mod-update-group.php",        data: {    post: post,   comment: comment },   success: function(data) {      $("#update-ex' + id_group + '").html("<b>Cập nhật thành công</b>");   setTimeout(() => {      $("#update-ex' + id_group + '").html("");   }, 1500);      }    });   }); $("#update-ex' + id_group + '").css("color","#fff"); <\/script><div class="group-content"> <div class="form-group" style="position:relative;"> <div id="fquestion-' + id_question + '"> <div class="box-question"> <label for="comment-' + id_question + '">Nội dung câu hỏi:</label> <span> <button type="button" onclick="delete_question(' + id_question + ',' + id_group + ')" class="btn btn-danger delete-group" >Xóa câu này</button></span> <textarea required name="question_title_' + id_question + '" class="form-control" rows="5" id="comment-' + id_question + '"></textarea> <span id="update-comment-' + id_question + '"> </span><script>    $("#comment-' + id_question + '").on("change", function() {     var post = ' + id_question + ';        var comment = $.trim($(this).val());       if (comment == "") {         swal("Error !!!", "Không được để trống !", "error");          return;          }      $.ajax({       type: "POST",       url: "../survey/mod-update-question.php",         data: {        post: post,      comment: comment      },      success: function(data) {       $("#update-comment-' + id_question + '").html("<b>Cập nhật thành công</b>");      setTimeout(() => {         $("#update-comment-' + id_question + '").html("");       }, 1500);     }  });    });    $("#update-comment-' + id_question + '").css("color","red");  <\/script> </div> </div> <input type="hidden" id="question_number-' + id_group + '" name="question_number[]" value="1"> <div id="show_question-' + id_group + '"></div>  </div> <button type="button" class="btn btn-primary pqt-btn" onclick="add_question(' + id_group + ');">Thêm câu hỏi mới</button> <span>Cho phép người dùng thêm ý kiến<span> <div> <input type="hidden" name="vote_' + id_group + '" value="0"> <input value="1" checked name="vote_' + id_group + '" type="checkbox" id="cbx-' + id_group + '" style="display:none" /> <label for="cbx-' + id_group + '" class="toggle"> <span> <svg width="10px" height="10px" viewBox="0 0 10 10"> <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>  </svg> </span> </label>  </div> <script>  $("#cbx-' + id_group + '").on("change", function() {   var post = ' + id_group + ';   var apply = $(this).is(":checked") ? 1 : 0;   $.ajax({       type: "POST",           url: "../survey/mod-update-checkbox.php",         data: {          post: post,     apply: apply   },   success: function(data) {            swal("Done !!!", "Cập nhật thành công!", "success");     }    });    });  <\/script></div> </div></div> <style>   #cbx-' + id_group + ':checked + .toggle:before { background: #52d66b; } #cbx-' + id_group + ':checked + .toggle span { transform: translateX(18px); } #cbx-' + id_group + ':checked + .toggle span path {   stroke: #52d66b;   stroke-dasharray: 25;   stroke-dashoffset: 25; } </style>').insertBefore("#show_group");

            }
        });



    });

    function delete_group(id) {
        var id_survey = <?php echo $survey_id; ?>;
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/survey/mod-delete-group.php",
            data: {
                id: id,
                id_survey: id_survey,
            },
            success: function(data) {
                $("#fgroup-" + id + "").remove();
                swal("Chúc mừng !!!", "Bạn đã xóa thành công!", "success");

            }
        });


    }


    // Add, Delete Question 

    var question_number = 0;

    var id_post;

    function add_question(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/survey/mod-add-question.php",
            data: {
                id: id
            },
            success: function(data) {
                id_post = parseInt(data);
                question_number = $("#question_number-" + id + "").val();
                question_number++;
                $("#question_number-" + id + "").val(question_number);
                $('<div id="fquestion-' + id_post + '"><div class="box-question" ><label for="comment-' + id_post + '">Nội dung câu hỏi:</label> <span> <button type="button" class="btn btn-danger delete-group" onclick="delete_question(' + id_post + ',' + id + ')">Xóa câu này</button></span>  <textarea name="question_title_' + id_post + '[]" class="form-control" rows="5" id="comment-' + id_post + '"></textarea><span id="update-comment-' + id_post + '"> </span><script>    $("#comment-' + id_post + '").on("change", function() {     var post = ' + id_post + ';        var comment = $.trim($(this).val());       if (comment == "") {         swal("Error !!!", "Không được để trống !", "error");          return;          }      $.ajax({       type: "POST",       url: "../survey/mod-update-question.php",         data: {        post: post,      comment: comment      },      success: function(data) {       $("#update-comment-' + id_post + '").html("<b>Cập nhật thành công</b>");      setTimeout(() => {         $("#update-comment-' + id_post + '").html("");       }, 1500);     }  });    });    $("#update-comment-' + id_post + '").css("color","red");  <\/script> </div></div>').insertBefore("#show_question-" + id + "");
                swal("Chúc mừng !!!", "Thêm câu hỏi thành công", "success");

            }
        });

    };

    function delete_question(id, id_group) {

        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/survey/mod-delete-question.php",
            data: {
                id: id,
                id_group: id_group
            },
            success: function(data) {
                question_number = $("#question_number-" + id_group + "").val();
                question_number--;
                $("#question_number-" + id_group + "").val(question_number);
                $("#fquestion-" + id + "").remove();
                swal("Chúc mừng !!!", "Bạn đã xóa thành công!", "success");

            }
        });



    }
</script>


<!-- <?php
        if (isset($_POST['submit'])) {
            $surveytitle = $_POST['survey_title'];

            $item = 1;
            $group_title_update = "";
            $vote_update = 0;
            foreach ($_POST['question_number'] as $value) {
                // update group, vote
                while (!isset($_POST["group_title_$item"]) && !isset($_POST["vote_$item"])) {
                    $item++;
                }
                if (isset($_POST["group_title_$item"]) && isset($_POST["group_title_$item"])) {
                    $group_title_update = $_POST["group_title_$item"];
                    $vote_update = $_POST["vote_$item"];
                    $stringSQL = "update survey_groups set vote=" . $vote_update . " and group_title='" . $group_title_update . "' where group_id=" . $item . "";
                    $query = mysqli_query($conn, $stringSQL);
                    if (!$query) {
                        echo '<script>
                        swal("Lỗi !!!", "Có lỗi khi cập nhật Groups: ' . mysqli_error($conn) . '", "error");
                            </script>';
                    }
                    $item++;
                }

                // update question
                $item = 1;
                $item2 = 1;
                for ($i = 0; $i < $value; $i++) {
                    while (!isset($_POST["question_title_$item"])) {
                        $item++;
                    }
                    if (isset($_POST["question_title_$item"])) {
                        $question_title_update = $_POST["question_title_$item"];
                        $stringSQL = "update survey_questions set question_title='" . $question_title_update . "' where question_id=" . $item . "";
                        $query = mysqli_query($conn, $stringSQL);
                        if (!$query) {
                            echo '<script>
                            swal("Lỗi !!!", "Có lỗi khi cập nhật Câu hỏi: ' . mysqli_error($conn) . '", "error");
                                </script>';
                        }
                        $item++;
                    }
                }
            }
            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>  --> 