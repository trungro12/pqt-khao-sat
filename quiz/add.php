<?php include '../header.php';
pqt_permission();
?>

<div class="page-content">
    <div class="container">
        <br />
        <form action="" method="POST">
            <div class="form-group" style='position:relative;'>
                <div class="col-xs-12">
                    <div class="introduce">
                        <label for="quiz_title" style='text-align:center;font-weight: bold;font-size: 25px;'>Tiêu đề trắc nghiệm</label>
                        <input required name="quiz_title" class="form-control" id="quiz_title" type="text">
                       
                    </div>
                </div>
            </div>
            <div style="">
                <label for="quiz_time" class="inp">
                    <input required name="quiz_time" type="number" id="quiz_time" placeholder="&nbsp;">
                    <span class="label">Thời gian (phút)</span>
                    <span class="border"></span>
                </label>
                <br />
                <br />
                <label for="max_question" class="inp">
                    <input name="max_question" type="number" id="max_question" placeholder="&nbsp;">
                    <span class="label">Số câu hỏi trong 1 đề (bỏ trống hoặc ghi 0 để không giới hạn)</span>
                    <span class="border"></span>
                </label>
                <b style="color:red">Số câu hỏi trong 1 đề : là chức năng hệ thống chọn lọc ra những câu hỏi ngẫu nhiên gói lại trong 1 đề thi. Ví dụ bạn ghi là 10 mà trong trắc nghiệm này có 30 câu. Hệ thống sẽ lấy ngẫu nhiên 10 câu, như vậy sẽ tạo ra được rất nhiều đề thi mà không tốn nhiều công sức.</b>
                <br />
                <br />
                <span>Public (Chế độ mở, thí sinh có thể vào thi)<span>
                        <div>
                            <input type="hidden" name="public" value="0">
                            <input value="1" name="public" checked type="checkbox" id="cbx" style="display:none" />
                            <label for="cbx" class="toggle">
                                <span>
                                    <svg width="10px" height="10px" viewBox="0 0 10 10">
                                        <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                                    </svg>
                                </span>
                            </label>
                        </div>
            </div>
            <div class="survey-content">

                <div id='fgroup-0'>

                    <div class="group">
                        <div class="group-title">
                            <span>
                                <div class="col-xs-4">
                                    <label for="ex0">Tiêu đề câu hỏi.</label>
                                    <input required name="group_title[]" class="form-control" id="ex0" type="text">
                                </div>
                            </span>
                            <!-- <span> <button onclick="delete_group(0)" class='btn btn-danger delete-group' type="button">Xóa câu này</button></span> -->
                        </div>
                        <div class="group-content">
                            <div class="form-group" style='position:relative;'>
                                <table>
                                    <tr>
                                        <th>Nội dung kết quả</th>
                                        <th>Kết quả đúng</th>
                                    </tr>
                                    <tbody id="fquestion-0">
                                        <tr>
                                            <td>

                                                <div class="box-question">
                                                    <!-- <label for="comment-0"></label> -->
                                                    <!-- <span> <button onclick="delete_result(0,0)" class='btn btn-danger delete-group' href="#" style="top : 0;" type="button">Xóa kết quả này</button></span> -->
                                                    <textarea style="max-width: 1000px;" required name="result_title[]" class="form-control" rows="5" id="comment-0"></textarea>

                                                </div>
                                            </td>
                                            <td>
                                                <!-- True REsult -->
                                                <div class="cntr">
                                                    <label for="true_0" class="radio">
                                                        <input type="radio" name="true_0" id="true_0" value="0" class="hidden" />
                                                        <span class="label"></span>
                                                    </label>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id='show_question-0'>

                                    </tbody>

                                </table>


                                <input type="hidden" id="result_number-0" name="result_number[]" value="1">
                            </div>
                            <button type='button' class='btn btn-primary pqt-btn full' onclick='add_result(0);'>Thêm kết quả mới</button>
                        </div>
                    </div>
                </div>

                <div id='show_group'></div>
                <button type='button' class='btn btn-success pqt-btn full' id='add_group' href="#">Thêm câu hỏi mới</button>

                <button class='btn btn-primary pqt-btn full' name='submit' type='submit'>Tiến hành tạo trắc nghiệm</button>
        </form>
    </div>

</div>
</div>
<div class="quiz-list">
    <ul>
        <li id="s-fgroup-0-li"><a id="s-fgroup-0" href="#fgroup-0">Câu hỏi</a></li>
        <p id="show-list"></p>
    </ul>
</div>
<?php include '../footer.php' ?>

<script>
    // Add, Delete Group 
    var id_group = 0;
    var id_result = 0;
    $("#add_group").click(function() {
        id_group++;
        id_result++;
        $('<div id="fgroup-' + id_group + '"> <br /> <br /><div class="group">   <div class="group-title">     <span>   <div class="col-xs-4"> <label for="ex' + id_group + '">Tiêu đề câu hỏi.</label> <input required name="group_title[]" class="form-control" id="ex' + id_group + '" type="text"> </div>   </span>  <span> <button type="button" onclick="delete_group(' + id_group + ')" class="btn btn-danger delete-group">Xóa câu này</button></span>  </div>  <div class="group-content">  <div class="form-group" style="position:relative;"> <table>     <tr>  <th>Nội dung kết quả</th>  <th>Kết quả đúng</th>  </tr><tbody id="fquestion-' + id_result + '"> <tr>    <td>  <div class="box-question">  <span> <button onclick="delete_result(' + id_result + ',' + id_group + ')" class="btn btn-danger delete-group" style="top : 0;" type="button">Xóa kết quả này</button></span> <textarea style="max-width: 1000px;" required name="result_title[]" class="form-control" rows="5" id="comment-' + id_result + '"></textarea> </div> </td>   <td>    <div class="cntr">  <label for="true_' + id_result + '" class="radio">   <input type="radio" name="true_' + id_group + '" id="true_' + id_result + '" value="' + id_result + '" class="hidden" />    <span class="label"></span> </label>  </div>  </td>   </tr>    </tbody>  <tbody id="show_question-' + id_group + '">  </tbody>    </table><input type="hidden" id="result_number-' + id_group + '" name="result_number[]" value="1"></div> <button type="button" class="btn btn-primary pqt-btn full" onclick="add_result(' + id_group + ');">Thêm kết quả mới</button>  </div>  </div> </div>').insertBefore("#show_group");

        $('<li id="s-fgroup-' + id_group + '-li"><a id="s-fgroup-' + id_group + '" href="#fgroup-' + id_group + '">Câu hỏi</a></li>').insertBefore("#show-list");
    });

    function delete_group(id) {
       
        if (id < 0) id = 0;
        else {
            id_group--;
            $("#fgroup-" + id + "").remove();
            $("#s-fgroup-" + id + "").remove();
            $("#s-fgroup-" + id + "-li").remove();
        }
    }


    // Add, Delete Question 

    var result_number = 0;


    function add_result(id) {
        id_result++;
        result_number = $("#result_number-" + id + "").val();
        result_number++;
        $("#result_number-" + id + "").val(result_number);
        $('<tbody id="fquestion-' + id_result + '"> <tr><td> <div class="box-question"> <span> <button onclick="delete_result(' + id_result + ',' + id_group + ')" class="btn btn-danger delete-group" style="top : 0;" type="button">Xóa kết quả này</button></span> <textarea style="max-width: 1000px;" required name="result_title[]" class="form-control" rows="5" id="comment-' + id_result + '"></textarea>  </div>   </td> <td> <div class="cntr"> <label for="true_' + id_result + '" class="radio"><input type="radio" name="true_' + id_group + '" id="true_' + id_result + '" value="' + id_result + '" class="hidden" /> <span class="label"></span>   </label> </div>  </td> </tr> </tbody>').insertBefore("#show_question-" + id + "");
    };

    function delete_result(id, id_group) {
        if (id < 0) id = 0;
        else {
            result_number = $("#result_number-" + id_group + "").val();
            result_number--;
            $("#result_number-" + id_group + "").val(result_number);
            $("#fquestion-" + id + "").remove();

        }
    }
</script>


<?php
if (isset($_POST['submit'])) {
    $count = 0;
    $k = 0;
    $quiz_title = mysql_real_escape_string($_POST['quiz_title']);
    $quiz_time = $_POST['quiz_time'];
    $public = $_POST['public'];
    $max_question = (isset($_POST['max_question'])) ? $_POST['max_question'] : 0;
    $stringSQL = "insert INTO quiz(quiz_title,quiz_group,date,time,max_question,public) values('" . $quiz_title . "','',now()," . $quiz_time . "," . $max_question . "," . $public . ")";
    
    $query = mysqli_query($conn, $stringSQL);
    if (!$query) {
        echo '<script>
    swal("Lỗi !!!", "Có lỗi khi tạo trắc nghiệm' . mysqli_error($conn) . '", "error");
</script>';
        exit;
    } else {

        // get id quiz
        $quiz_id = mysqli_insert_id($conn);


        $group_title = array_values($_POST['group_title']);
        // $vote_group = array_values($_POST['vote']);
        $item = 0;
        $result_title = array_values($_POST['result_title']);
        foreach ($_POST['result_number'] as $number_result) {

            // insert groups
            $content_group = $group_title[$k];
            
            $stringSQL = "insert INTO quiz_groups(group_title,date,group_result,true_result) values('" . $content_group . "',now(),'','')";
            $query = mysqli_query($conn, $stringSQL);
            if (!$query) {
                echo '<script>
            swal("Lỗi !!!", "Có lỗi khi thêm Tên Groups", "error");
        </script>';
                exit;
            } else {
                // Fetch id group
                $idgroup = mysqli_insert_id($conn);

                for ($i = $count; $i < $number_result + $count; $i++) {
                    $content_result = $result_title[$i];
               
                    $stringSQL = "insert INTO quiz_result(result_title,date) values('" . $content_result . "',now())";
                    $query = mysqli_query($conn, $stringSQL);

                    if (!$query) {
                        echo '<script> swal("Lỗi !!!", "Có lỗi khi thêm Câu hỏi", "error");  </script>';
                        exit;
                    } else {
                        // get id quiz result
                        $id_result = mysqli_insert_id($conn);
                        // get true result
                        if (isset($_POST["true_$k"]) && $i == $_POST["true_$k"]) {
                            $stringSQL = "update quiz_groups set group_result = CONCAT(group_result, '" . $id_result . "','-pqt-'), true_result = " . intval($id_result) . " where group_id = " . $idgroup . "";
                        }
                        else $stringSQL = "update quiz_groups set group_result = CONCAT(group_result, '" . $id_result . "','-pqt-')  where group_id = " . $idgroup . "";
                        $query = mysqli_query($conn, $stringSQL);
                        if (!$query) {
                            echo '<script> swal("Lỗi !!!", "Có lỗi khi thêm vào group '.mysqli_error($conn).'", "error");  </script>';
                            exit;
                        }

                    }
                }

                $stringSQL = "update quiz set quiz_group = CONCAT(quiz_group, '" . $idgroup . "','-pqt-') where quiz_id = " . $quiz_id . "";
                $query = mysqli_query($conn, $stringSQL);
            }

            $count = $number_result;
            $k++;
        }
        $here = "<a href='" . $baseurl . "/quiz/edit.php?quiz_id=" . $quiz_id . "'>Xem tại đây</a>";
        echo '<script> swal({title: "Thành công !!!",html:true,text: "Thêm trắc nghiệm thành công!!!\n ' . $here . '", type:"success"});  </script>';
    }
}
?> 