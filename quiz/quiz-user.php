<?php include '../header.php';
pqt_permission();
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
                <span>Public (Chế độ mở, thí sinh có thể vào thi)<span>
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
                <div id='fgroup-0'>

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
                                        <th>Điểm (Sẽ tự động điền khi thí sinh làm bài)</th>
                                    </tr>
                                    <?php
                                    $quiz_id = $_GET['quiz_id'];
                                    $stringSQL = "select * from quiz_user where quiz_id = " . $quiz_id . "";
                                    $query = mysqli_query($conn, $stringSQL);
                                    // $dataUser = mysqli_fetch_array($query);
                                    // print_r($dataUser);
                                    if (!is_admin()) {
                                        if (!$dataUser) {
                                            echo '<script> swal("Lỗi !!!", "Không có dữ liệu!!!", "error");  </script>';
                                            exit;
                                        }
                                    }
                                    while($dataUser = mysqli_fetch_array($query)) {
                                        $user_id = $dataUser['user_id'];
                                            ?>
                                    <!-- html -->

                                    <tbody id="quiz-user<?php echo $user_id; ?>">
                                        <tr>
                                            <td>
                                                <div class="box-question">
                                                   
                                                    <input type="text" style="max-width: 1000px;" name="user_name_<?php echo $user_id; ?>" class="form-control" value="<?php echo  $dataUser['user_name']; ?>" id="name-<?php echo $user_id; ?>">
                                                    <span id="update-name-<?php echo $user_id; ?>"> </span>
                                                    <script>
                                                        $("#name-<?php echo $user_id; ?>").on("change", function() {
                                                            var post = <?php echo $user_id; ?>;
                                                            var comment = $.trim($(this).val());
                                                            var col = "user_name";
                                                            if (comment == "") {
                                                                swal("Error !!!", "Không được để trống !", "error");
                                                                return;
                                                            }
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "../quiz/mod-update-user.php",
                                                                data: {
                                                                    post: post,
                                                                    comment: comment,
                                                                    col:col
                                                                },
                                                                success: function(data) {

                                                                    $("#update-name-<?php echo $user_id; ?>").html("<b>Cập nhật thành công</b>");
                                                                    setTimeout(() => {
                                                                        $("#update-name-<?php echo $user_id; ?>").html("");
                                                                    }, 1500);

                                                                }
                                                            });
                                                        });
                                                        $("#update-name-<?php echo $user_id; ?>").css("color", "red");
                                                    </script>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="box-question">
                                                   
                                                    <input type="text" style="max-width: 1000px;" name="user_class_<?php echo $user_id; ?>" class="form-control" value="<?php echo  $dataUser['user_class']; ?>" rows="5" id="class-<?php echo $user_id; ?>">
                                                    <span id="update-class-<?php echo $user_id; ?>"> </span>
                                                    <script>
                                                        $("#class-<?php echo $user_id; ?>").on("change", function() {
                                                            var post = <?php echo $user_id; ?>;
                                                            var comment = $.trim($(this).val());
                                                            var col = "user_class";
                                                            if (comment == "") {
                                                                swal("Error !!!", "Không được để trống !", "error");
                                                                return;
                                                            }
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "../quiz/mod-update-user.php",
                                                                data: {
                                                                    post: post,
                                                                    comment: comment,
                                                                    col:col
                                                                },
                                                                success: function(data) {

                                                                    $("#update-class-<?php echo $user_id; ?>").html("<b>Cập nhật thành công</b>");
                                                                    setTimeout(() => {
                                                                        $("#update-class-<?php echo $user_id; ?>").html("");
                                                                    }, 1500);

                                                                }
                                                            });
                                                        });
                                                        $("#update-class-<?php echo $user_id; ?>").css("color", "red");
                                                    </script>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="box-question">
                                                  
                                                    <input type="text" style="max-width: 1000px;" name="user_mssv_<?php echo $user_id; ?>" class="form-control" value="<?php echo  $dataUser['user_mssv']; ?>" id="mssv-<?php echo $user_id; ?>">
                                                    <span id="update-mssv-<?php echo $user_id; ?>"> </span>
                                                    <script>
                                                        $("#mssv-<?php echo $user_id; ?>").on("change", function() {
                                                            var post = <?php echo $user_id; ?>;
                                                            var comment = $.trim($(this).val());
                                                            var col = "user_mssv";
                                                            if (comment == "") {
                                                                swal("Error !!!", "Không được để trống !", "error");
                                                                return;
                                                            }
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "../quiz/mod-update-user.php",
                                                                data: {
                                                                    post: post,
                                                                    comment: comment,
                                                                    col:col
                                                                },
                                                                success: function(data) {

                                                                    $("#update-mssv-<?php echo $user_id; ?>").html("<b>Cập nhật thành công</b>");
                                                                    setTimeout(() => {
                                                                        $("#update-mssv-<?php echo $user_id; ?>").html("");
                                                                    }, 1500);

                                                                }
                                                            });
                                                        });
                                                        $("#update-mssv-<?php echo $user_id; ?>").css("color", "red");
                                                    </script>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="box-question">
                                                    <span> <button style="top:0;" type='button' onclick="delete_user(<?php echo $user_id; ?>)" class='btn btn-danger delete-group'>Xóa</button></span>
                                                    <input style="max-width: 1000px;" name="user_score_<?php echo $user_id; ?>" class="form-control" type="text" value="<?php echo  $dataUser['score']; ?>" id="score-<?php echo $user_id; ?>">
                                                    <span id="update-score-<?php echo $user_id; ?>"> </span>
                                                    <script>
                                                        $("#score-<?php echo $user_id; ?>").on("change", function() {
                                                            var post = <?php echo $user_id; ?>;
                                                            var comment = $.trim($(this).val());
                                                            var col = "score";
                                                            var isnum = 1;
                                                            if (comment == "") {
                                                                swal("Error !!!", "Không được để trống !", "error");
                                                                return;
                                                            }
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "../quiz/mod-update-user.php",
                                                                data: {
                                                                    post: post,
                                                                    comment: comment,
                                                                    col:col,
                                                                    isnum:isnum
                                                                },
                                                                success: function(data) {

                                                                    $("#update-score-<?php echo $user_id; ?>").html("<b>Cập nhật thành công</b>");
                                                                    setTimeout(() => {
                                                                        $("#update-score-<?php echo $user_id; ?>").html("");
                                                                    }, 1500);

                                                                }
                                                            });
                                                        });
                                                        $("#update-score-<?php echo $user_id; ?>").css("color", "red");
                                                    </script>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php

                              
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

    function add_user(ids) {
        // var id = ids+1;
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/quiz/mod-add-user.php",
            data: {
                id: ids
            },
            success: function(data) {
                id = parseInt(data);
                $('<tbody id="quiz-user'+id+'"> <tr>  <td>      <div class="box-question">             <input style="max-width: 1000px;" name="user_name_'+id+'" class="form-control" type="text" id="name-'+id+'">  <span id="update-name-'+id+'"> </span> <script>             $("#name-'+id+'").on("change", function() {          var post = '+id+';       var comment = $.trim($(this).val());      var col = "user_name";      if (comment == "") {      swal("Error !!!", "Không được để trống !", "error");        return;      }       $.ajax({    type: "POST",      url: "../quiz/mod-update-user.php",     data: {      post: post,     comment: comment,      col:col       },    success: function(data) {      $("#update-name-'+id+'").html("<b>Cập nhật thành công</b>");   setTimeout(() => {     $("#update-name-'+id+'").html("");    }, 1500);      }     });       });         $("#update-name-'+id+'").css("color", "red");    <\/script>    </div>         </td>          <td>   <div class="box-question">    <input style="max-width: 1000px;" name="user_class_'+id+'" type="text" class="form-control"   id="class-'+id+'">                    <span id="update-class-'+id+'"> </span>   <script>       $("#class-'+id+'").on("change", function() {      var post = '+id+';     var comment = $.trim($(this).val());      var col = "user_class";      if (comment == "") {       swal("Error !!!", "Không được để trống !", "error");     return;         }        $.ajax({        type: "POST",        url: "../quiz/mod-update-user.php",        data: {         post: post,        comment: comment,       col:col      },   success: function(data) {     $("#update-class-'+id+'").html("<b>Cập nhật thành công</b>");       setTimeout(() => {    $("#update-class-'+id+'").html("");      }, 1500);        }        });   });   $("#update-class-'+id+'").css("color", "red");    <\/script>      </div>        </td>         <td>     <div class="box-question">   <input style="max-width: 1000px;" name="user_mssv_'+id+'" type="text" class="form-control"  id="mssv-'+id+'">      <span id="update-mssv-'+id+'"> </span>   <script>       $("#mssv-'+id+'").on("change", function() {  var post = '+id+';  var comment = $.trim($(this).val());     var col = "user_mssv";        if (comment == "") {      swal("Error !!!", "Không được để trống !", "error");        return;              }         $.ajax({               type: "POST",                url: "../quiz/mod-update-user.php",         data: {             post: post,        comment: comment,              col:col               },     success: function(data) {  $("#update-mssv-'+id+'").html("<b>Cập nhật thành công</b>");       setTimeout(() => {  $("#update-mssv-'+id+'").html("");      }, 1500);          }      });          });       $("#update-mssv-'+id+'").css("color", "red");     <\/script>    </div>      </td>        <td>     <div class="box-question">   <span> <button style="top:0;" type="button" onclick="delete_user('+id+')" class="btn btn-danger delete-group">Xóa</button></span><input style="max-width: 1000px;" name="user_score_'+id+'" type="text" class="form-control" id="score-'+id+'">    <span id="update-score-'+id+'"> </span> <script> $("#score-'+id+'").on("change", function() { var post = '+id+'; var comment = $.trim($(this).val()); var col = "score"; var isnum = 1; if (comment == "") { swal("Error !!!", "Không được để trống !", "error"); return; } $.ajax({ type: "POST", url: "../quiz/mod-update-user.php", data: { post: post, comment: comment, col:col, isnum:isnum }, success: function(data) { $("#update-score-'+id+'").html("<b>Cập nhật thành công</b>"); setTimeout(() => { $("#update-score-'+id+'").html(""); }, 1500); } }); }); $("#update-score-'+id+'").css("color", "red"); <\/script> </div> </td> </tr> </tbody>').insertBefore("#show_question-" + ids + "");
                swal("Chúc mừng !!!", "Thêm  thành viên", "success");

            }
        });

    };


    function delete_user(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/quiz/mod-delete-user.php",
            data: {
                id: id,
            },
            success: function(data) {
                $("#quiz-user" + id + "").remove();
                swal("Chúc mừng !!!", "Bạn đã xóa thành công!", "success");

            }
        });
    }
</script>


<?php

?> 