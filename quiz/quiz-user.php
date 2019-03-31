<?php include '../header.php';
?>

<div class="page-content">
    <div class="container">
        <br />

        <?php

        if (isset($_GET['quiz_id'])) {
            $quiz_id = $_GET['quiz_id'];
            $stringSQL = "select * from quiz where quiz_id=" . $quiz_id;
            $dataQuiz = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
            if (!$dataQuiz) {
                echo '<script> swal("Lỗi !!!", "Đường dẫn sai hoặc đã bị xóa!!!", "error");  </script>';
                exit;
            }
            $last_id_group = 0;
            $last_id_result = 0;
            ?>
        <!-- html -->
        <form action="" method="POST">
            <div class="introduce">
                <div class="form-group" style='position:relative;'>
                    <div class="col-xs-12">
                        <label for="quiz_title" style='text-align:center;font-weight: bold;font-size: 25px;'>Danh sách thí sinh tham dự <?php echo $dataQuiz['quiz_title']; ?></label>
                    </div>
                    <br />
                    <?php
                    if (is_admin()) {

                        ?>
                    <a href="<?php echo $baseurl; ?>/quiz/view.php?quiz_id=<?php echo $quiz_id; ?>" class='btn btn-primary'>Xem</a>
                    <a href="<?php echo $baseurl; ?>/quiz/edit.php?quiz_id=<?php echo $quiz_id; ?>" class='btn btn-primary'>Sửa</a>
                    <button id="delete_quiz" type="button" class='btn btn-danger'>Xóa</button>
                    <?php

                }
                ?>
                </div>
            </div>
            <!-- end update Quiz title -->

            <br />
            <!-- update timequiz, public -->
            <?php
            if (is_admin()) {
                ?>
            <div style="">
                <label for="quiz_time" class="inp">
                    <input value="<?php echo $dataQuiz['time']; ?>" required name="quiz_time" type="number" id="quiz_time" placeholder="&nbsp;">
                    <span class="label">Thời gian (phút)</span>
                    <span class="border"></span>
                    <span id="update-time"> </span>
                </label>
                <span>Cho phép xem điểm và kết quả khi thi xong<span>
                        <div>
                            <input type="hidden" name="public" value="0">
                            <input value="1" name="public" type="checkbox" id="cbx" style="display:none" />
                            <label for="cbx" class="toggle">
                                <span>
                                    <svg width="10px" height="10px" viewBox="0 0 10 10">
                                        <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                                    </svg>
                                </span>
                            </label>
                        </div>
            </div>

            <?php if ($dataQuiz['public'] == 1) echo '<script> 
                                        $("#cbx").prop( "checked", true );
                                        </script>'; ?>

            <script>
                $("#cbx").on("change", function() {
                    var post = <?php echo $quiz_id; ?>;
                    var apply = $(this).is(':checked') ? 1 : 0;

                    $.ajax({
                        type: "POST",
                        url: "../quiz/mod-update-public.php",
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

            <script>
                $("#quiz_time").on("change", function() {
                    var post = <?php echo $quiz_id; ?>;
                    var comment = $.trim($(this).val());
                    if (comment == "") {
                        swal("Error !!!", "Không được để trống !", "error");
                        return;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../quiz/mod-update-time.php",
                        data: {
                            post: post,
                            comment: comment
                        },
                        success: function(data) {

                            $("#update-time").html("<b>Cập nhật thành công</b>");
                            setTimeout(() => {
                                $("#update-time").html("");
                            }, 1500);

                        }
                    });
                    $("#update-time").css("color", "red");

                });
            </script>
            <?php

        }
        ?>

            <!-- end update timequiz, public -->

            <!-- Update result, insert result************************************************************** -->
            <div class="survey-content">

                <!-- html -->
                <div id='fgroup-<?php echo $id_group; ?>'>

                    <div class="group">
                        <div class="group-title">
                            <span>
                                <div class="col-xs-4">
                                    <b>Danh sách bao gồm. </b>
                                </div>
                            </span>
                        </div>
                        <div class="group-content">

                            <!-- List Result -->
                            <div class="form-group" style='position:relative;'>
                                <table>
                                    <tr>
                                        <th>Họ và tên</th>
                                        <th>Lớp học</th>
                                        <th>Mã số sinh viên</th>
                                    </tr>
                                    <?php
                                    $quiz_id = $_GET['quiz_id'];
                                    $stringSQL = "select * from quiz_user where quiz_id like %" . $quiz_id . "-pqt-%";
                                    $dataUser = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                                    if (!is_admin()) {
                                            if (!$dataUser) {
                                                    echo '<script> swal("Lỗi !!!", "Không có dữ liệu!!!", "error");  </script>';
                                                    exit;
                                                }
                                        }
                                    foreach ($dataUser as $User) {

                                        if ($idUser == "" || $idUser == null) {
                                            continue;
                                            ?>
                                    <!-- html -->

                                    <tbody id="quiz-user<?php echo $User['user_id']; ?>">
                                        <div class="box-question">
                                            <span> <button style="top:0;" type='button' onclick="delete_result(<?php echo $User['user_id']; ?>)" class='btn btn-danger delete-group'>Xóa thành viên này</button></span>
                                            <textarea style="max-width: 1000px;" required name="user_title_<?php echo $User['user_id']; ?>" class="form-control" rows="5" id="comment-<?php echo $User['user_id']; ?>"><?php echo  $User['user_id']; ?></textarea>
                                            <span id="update-comment-<?php echo $User['user_id']; ?>"> </span>
                                            <script>
                                                $("#comment-<?php echo $User['user_id']; ?>").on("change", function() {
                                                    var post = <?php echo $User['user_id']; ?>;
                                                    var comment = $.trim($(this).val());
                                                    if (comment == "") {
                                                        swal("Error !!!", "Không được để trống !", "error");
                                                        return;
                                                    }
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "../quiz/mod-update-result.php",
                                                        data: {
                                                            post: post,
                                                            comment: comment
                                                        },
                                                        success: function(data) {

                                                            $("#update-comment-<?php echo $id_result; ?>").html("<b>Cập nhật thành công</b>");
                                                            setTimeout(() => {
                                                                $("#update-comment-<?php echo $id_result; ?>").html("");
                                                            }, 1500);

                                                        }
                                                    });
                                                });
                                                $("#update-comment-<?php echo $id_result; ?>").css("color", "red");
                                            </script>




                                        </div>

                                    </tbody>
                                    <?php

                                }
                            }
                            ?>
                                    <tbody id='show_question-<?php echo  $quiz_id; ?>'>
                                    </tbody>

                                </table>



                            </div>

                            <input type="hidden" id="result_number-<?php echo  $quiz_id; ?>" name="result_number[]" value="<?php echo $result_count; ?>">
                            <button type='button' class='btn btn-primary pqt-btn full' onclick='add_user(<?php echo  $quiz_id; ?>);'>Thêm kết quả mới</button>
                        </div>
                    </div>
                </div>




        </form>
        <?php

    } else {
        echo '<script> swal("Lỗi !!!", "Đường dẫn sai hoặc không tồn tại!!!", "error");  </script>';
    }
    ?>
    </div>

</div>
</div>
<!-- <div class="quiz-list">
    <ul>
        <li id="s-fgroup-0-li"><a id="s-fgroup-0" href="#fgroup-0">Câu hỏi</a></li>
        <p id="show-list"></p>
    </ul>
</div>
 -->

<script>
    var local_quiz_id = <?php echo $quiz_id ?>;
    $(document).ready(function() {
        $("#delete_quiz").click(function() {
            var cf = confirm("Bạn có chắc muốn xóa?");
            var this_url = window.location.href;
            if (cf != true) return;
            else {
                $.ajax({
                    url: "../quiz/delete.php",
                    type: "POST",
                    data: {
                        id: local_quiz_id
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

<script>
    // Add, Delete Group 
    var id_group = <?php echo $last_id_group ?>;
    var id_result = <?php echo $last_id_result ?>;
    var quiz_id = <?php echo $quiz_id ?>;

   

    // Add, Delete Question 

    // Add, Delete Question 

    var result_number = 0;

    var id_result;

    function add_user(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/quiz/mod-add-user.php",
            data: {
                id: id
            },
            success: function(data) {
                id_result = parseInt(data);
                $('<tbody id="fquestion-' + id_result + '"> <tr><td> <div class="box-question"> <span> <button onclick="delete_result(' + id_result + ',' + id + ')" class="btn btn-danger delete-group" style="top : 0;" type="button">Xóa kết quả này</button></span> <textarea style="max-width: 1000px;" required name="result_title[]" class="form-control" rows="5" id="comment-' + id_result + '"></textarea>  <span id="update-comment-' + id_result + '"> </span><script>    $("#comment-' + id_result + '").on("change", function() {     var post = ' + id_result + ';        var comment = $.trim($(this).val());       if (comment == "") {         swal("Error !!!", "Không được để trống !", "error");          return;          }      $.ajax({       type: "POST",       url: "../quiz/mod-update-result.php",         data: {        post: post,      comment: comment      },      success: function(data) {       $("#update-comment-' + id_result + '").html("<b>Cập nhật thành công</b>");      setTimeout(() => {         $("#update-comment-' + id_result + '").html("");       }, 1500);     }  });    });    $("#update-comment-' + id_result + '").css("color","red");  <\/script> </div>   </td> <td> <div class="cntr"> <label for="true_' + id_result + '" class="radio"><input type="radio" name="true_' + id + '" id="true_' + id_result + '" value="' + id_result + '" class="hidden" /> <span class="label"></span>   </label> </div>  </td> </tr> </tbody>').insertBefore("#show_question-" + id + "");
                swal("Chúc mừng !!!", "Thêm đáp án thành công", "success");

            }
        });

    };


    function delete_result(id, id_group) {
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/quiz/mod-delete-result.php",
            data: {
                id: id,
                id_group: id_group
            },
            success: function(data) {
                result_number = $("#result_number-" + id_group + "").val();
                result_number--;
                $("#result_number-" + id_group + "").val(result_number);
                $("#fquestion-" + id + "").remove();
                swal("Chúc mừng !!!", "Bạn đã xóa thành công!", "success");

            }
        });
    }
</script>


<?php

?> 