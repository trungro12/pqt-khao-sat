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
                        <label for="quiz_title" style='text-align:center;font-weight: bold;font-size: 25px;'>Tiêu đề trắc nghiệm</label>
                        <input required value="<?php echo $dataQuiz['quiz_title']; ?>" name="quiz_title" class="form-control" id="quiz_title" type="text">
                        <span id="update-quiz"> </span>
                         
                    </div>
                    <br />
                    <?php
                    if (is_admin()) {

                        ?>
                     <a href="<?php echo $baseurl; ?>/quiz/quiz-user.php?quiz_id=<?php echo $quiz_id; ?>" class='btn btn-primary'>Danh sách dự thi</a>
                    <a href="<?php echo $baseurl; ?>/quiz/view.php?quiz_id=<?php echo $quiz_id; ?>" class='btn btn-primary'>Xem</a>
                    <button id="delete_quiz" type="button" class='btn btn-danger'>Xóa</button>
                    <?php

                }
                ?>
                    <script>
                        $("#quiz_title").on("change", function() {
                            var post = <?php echo $quiz_id; ?>;
                            var comment = $.trim($(this).val());
                            if (comment == "") {
                                swal("Error !!!", "Không được để trống !", "error");
                                return;
                            }
                            $.ajax({
                                type: "POST",
                                url: "../quiz/mod-update-quiz.php",
                                data: {
                                    post: post,
                                    comment: comment
                                },
                                success: function(data) {

                                    $("#update-quiz").html("<b style='color:#fff;'>Cập nhật thành công</b>");
                                    setTimeout(() => {
                                        $("#update-quiz").html("");
                                    }, 1500);

                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- end update Quiz title -->

            <br />
            <!-- update timequiz, public -->
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

            <!-- end update timequiz, public -->

            <!-- Update result, insert result************************************************************** -->
            <div class="survey-content">
                <?php
                $array_group = explode("-pqt-", $dataQuiz['quiz_group']);

                foreach ($array_group as $id_group) {
                    if ($id_group != "" || $id_group != null) {
                        $stringSQL = "select * from quiz_groups where group_id=" . $id_group;
                        $dataGroup = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                        $last_id_group = $id_group;
                        ?>
                <!-- html -->
                <div id='fgroup-<?php echo $id_group; ?>'>

                    <div class="group">
                        <div class="group-title">
                            <span>
                                <div class="col-xs-4">
                                    <label for="ex<?php echo $id_group; ?>">Tiêu đề câu hỏi.</label>
                                    <input required value="<?php echo $dataGroup['group_title']; ?>" name="group_title_<?php echo $id_group; ?>" id="ex<?php echo $id_group; ?>" class="form-control" type="text">
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
                                            url: "../quiz/mod-update-group.php",
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
                                <span> <button type="button" onclick="delete_group(<?php echo $id_group; ?>)" class='btn btn-danger delete-group'>Xóa câu này</button></span>
                            </span>
                        </div>
                        <div class="group-content">

                            <!-- List Result -->
                            <div class="form-group" style='position:relative;'>
                                <table>
                                    <tr>
                                        <th>Nội dung kết quả</th>
                                        <th>Kết quả đúng</th>
                                    </tr>
                                    <?php
                                    $result_count = 0;
                                    $array_result = explode("-pqt-", $dataGroup['group_result']);
                                    foreach ($array_result as $id_result) {

                                        if ($id_result != "" || $id_result != null) {
                                            $result_count++;
                                            $stringSQL = "select * from quiz_result where result_id=" . $id_result;
                                            $dataResult = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                                            $last_id_result = $id_result;
                                            ?>
                                    <!-- html -->

                                    <tbody id="fquestion-<?php echo $id_result; ?>">
                                        <tr>
                                            <td>

                                                <div class="box-question">
                                                    <span> <button style="top:0;" type='button' onclick="delete_result(<?php echo $id_result; ?>,<?php echo $id_group; ?>)" class='btn btn-danger delete-group'>Xóa kết quả này</button></span>
                                                    <textarea style="max-width: 1000px;" required name="result_title_<?php echo $id_result; ?>" class="form-control" rows="5" id="comment-<?php echo $id_result; ?>"><?php echo trim($dataResult['result_title']); ?></textarea>
                                                    <span id="update-comment-<?php echo $id_result; ?>"> </span>

                                                    <script>
                                                        $("#comment-<?php echo $id_result; ?>").on("change", function() {
                                                            var post = <?php echo $id_result; ?>;
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
                                            </td>
                                            <td>
                                                <!-- True REsult -->
                                                <div class="cntr">
                                                    <label for="true_<?php echo $id_result; ?>" class="radio">
                                                        <input <?php if ($dataGroup["true_result"] == $id_result) echo "checked"; ?> type="radio" name="true_<?php echo $id_group; ?>" id="true_<?php echo $id_result; ?>" value="<?php echo $id_result; ?>" class="hidden" />
                                                        <span class="label"></span>
                                                    </label>
                                                </div>
                                                <span id="update-true_result-<?php echo $id_result; ?>"> </span>
                                                <script>
                                                    $("#true_<?php echo $id_result; ?>").on("change", function() {
                                                        var id_result = <?php echo $id_result; ?>;
                                                        var id_group = <?php echo $id_group; ?>;
                                                        // if (apply == "") {
                                                        //     swal("Error !!!", "Không được để trống !", "error");
                                                        //     return;
                                                        // }
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "../quiz/mod-update-true_result.php",
                                                            data: {
                                                                id_result: id_result,
                                                                id_group: id_group
                                                            },
                                                            success: function(data) {

                                                                $("#update-true_result-<?php echo $id_result; ?>").html("<b>Cập nhật thành công</b>");
                                                                setTimeout(() => {
                                                                    $("#update-true_result-<?php echo $id_result; ?>").html("");
                                                                }, 1500);

                                                            }
                                                        });
                                                    });
                                                    $("#update-true_result-<?php echo $id_result; ?>").css("color", "red");
                                                </script>

                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php

                                }
                            }
                            ?>
                                    <tbody id='show_question-<?php echo $id_group; ?>'>
                                    </tbody>

                                </table>



                            </div>

                            <input type="hidden" id="result_number-<?php echo $id_group; ?>" name="result_number[]" value="<?php echo $result_count; ?>">
                            <button type='button' class='btn btn-primary pqt-btn full' onclick='add_result(<?php echo $id_group; ?>);'>Thêm kết quả mới</button>
                        </div>
                    </div>
                </div>

                <?php

            }
        }

        ?>

                <div id='show_group'></div>
                <button type='button' class='btn btn-success pqt-btn full' id='add_group' href="#">Thêm câu hỏi mới</button>


        </form>
        <?php

    } else {
        echo '<script> swal("Lỗi !!!", "Đường dẫn sai hoặc không tồn tại!!!", "error");  </script>';
    }
    ?>
    </div>

</div>
</div>
<div class="quiz-list">
    <ul>
        <li id="s-fgroup-0-li"><a id="s-fgroup-0" href="#fgroup-0">Câu hỏi</a></li>
        <p id="show-list"></p>
    </ul>
</div>


<script>
    var local_quiz_id = <?php echo $quiz_id ?>;
   $(document).ready(function(){
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
                   document.location.href= this_url;
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

    $("#add_group").click(function() {

        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/quiz/mod-add-group.php",
            data: {
                quiz_id: quiz_id
            },
            dataType: "json",
            success: function(data) {
                id_group = data.id_groups;
                id_result = data.id_results;
                console.log(data);

                // echo '';
                $('<div id="fgroup-'+id_group+'"> <div class="group"> <div class="group-title"> <span> <div class="col-xs-4"><label for="ex'+id_group+'">Tiêu đề câu hỏi.</label> <input required name="group_title_'+id_group+'" id="ex'+id_group+'"  class="form-control" type="text"> <span id="update-ex'+id_group+'"> </span> </div> <script> $("#ex'+id_group+'").on("change", function() { var post = '+id_group+';   var comment = $.trim($(this).val());  if (comment == "") {      swal("Error !!!", "Không được để trống !", "error");  return;     }     $.ajax({    type: "POST",    url: "../quiz/mod-update-group.php",     data: {         post: post,         comment: comment     },     success: function(data) {      $("#update-ex'+id_group+'").html("<b>Cập nhật thành công</b>");   setTimeout(() => { $("#update-ex'+id_group+'").html("");   }, 1500);   }   });  }); $("#update-ex'+id_group+'").css("color", "#fff"); <\/script> <span> <button type="button" onclick="delete_group('+id_group+')" class="btn btn-danger delete-group">Xóa câu này</button></span>   </span> </div> <div class="group-content">     <div class="form-group" style="position:relative;">   <table>    <tr>      <th>Nội dung kết quả</th>      <th>Kết quả đúng</th>     </tr>   <tbody id="fquestion-'+id_result+'">          <tr>            <td>      <div class="box-question">  <span> <button style="top:0;" type="button" onclick="delete_result('+id_result+','+id_group+')" class="btn btn-danger delete-group">Xóa kết quả này</button></span>  <textarea style="max-width: 1000px;" required name="result_title_'+id_result+'" class="form-control" rows="5" id="comment-'+id_result+'"></textarea>  <span id="update-comment-'+id_result+'"> </span>  <script>   $("#comment-'+id_result+'").on("change", function() {  var post = '+id_result+'; var comment = $.trim($(this).val());  if (comment == "") {   swal("Error !!!", "Không được để trống !", "error");    return;          }  $.ajax({         type: "POST",     url: "../quiz/mod-update-result.php",      data: {                 post: post,         comment: comment               },                   success: function(data) {   $("#update-comment-'+id_result+'").html("<b>Cập nhật thành công</b>");   setTimeout(() => {           $("#update-comment-'+id_result+'").html("");                  }, 1500);            }                  });            });    $("#update-comment-'+id_result+'").css("color", "red");    <\/script>                </div>     </td>   <td>   <div class="cntr"> <label for="true_'+id_result+'" class="radio">         <input type="radio" name="true_'+id_group+'" id="true_'+id_result+'" value="'+id_result+'" class="hidden" />     <span class="label"></span>        </label>     </div>  <span id="update-true_result-'+id_result+'"> </span>        <script>          $("#true_'+id_result+'").on("change", function() {  var id_result = '+id_result+';       var id_group = '+id_group+';                $.ajax({         type: "POST",  url: "../quiz/mod-update-true_result.php",     data: {        id_result: id_result,                    id_group: id_group            },        success: function(data) {         $("#update-true_result-'+id_result+'").html("<b>Cập nhật thành công</b>");     setTimeout(() => {     $("#update-true_result-'+id_result+'").html("");     }, 1500);         }       });    });     $("#update-true_result-'+id_result+'").css("color", "red");     <\/script>     </td>     </tr>  </tbody>   <tbody id="show_question-'+id_group+'">      </tbody>    </table>  </div>  <input type="hidden" id="result_number-'+id_group+'" name="result_number[]" value="1">  <button type="button" class="btn btn-primary pqt-btn full" onclick="add_result('+id_group+');">Thêm kết quả mới</button>  </div></div></div>').insertBefore("#show_group");

                $('<li id="s-fgroup-' + id_group + '-li"><a id="s-fgroup-' + id_group + '" href="#fgroup-' + id_group + '">Câu hỏi</a></li>').insertBefore("#show-list");
            }
        });



    });


    function delete_group(id) {
        var quiz_id = <?php echo $quiz_id; ?>;
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/quiz/mod-delete-group.php",
            data: {
                id: id,
                quiz_id: quiz_id,
            },
            success: function(data) {
                $("#fgroup-" + id + "").remove();
                $("#s-fgroup-" + id + "").remove();
                $("#s-fgroup-" + id + "-li").remove();
                swal("Chúc mừng !!!", "Bạn đã xóa thành công!", "success");
            }
        });


    }


    // Add, Delete Question 

    // Add, Delete Question 

    var result_number = 0;

    var id_result;

    function add_result(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo $baseurl ?>/quiz/mod-add-result.php",
            data: {
                id: id
            },
            success: function(data) {
                id_result = parseInt(data);
                result_number = $("#result_number-" + id + "").val();
                result_number++;
                $("#result_number-" + id + "").val(result_number);
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