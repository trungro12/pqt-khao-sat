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
                        <label for="survey_title" style='text-align:center;font-weight: bold;font-size: 25px;'>Tiêu đề khảo sát</label>
                        <input required name="survey_title" class="form-control" id="survey_title" type="text">
                    </div>
                </div>
            </div>
            <div class="survey-content">

                <div id='fgroup-0'>
                    <h3> Nhóm câu hỏi </h3>
                    <div class="group">
                        <div class="group-title">
                            <span>
                                <div class="col-xs-4">
                                    <label for="ex0">Tiêu đề nhóm câu khảo sát.</label>
                                    <input required name="group_title[]" class="form-control" id="ex0" type="text">
                                </div>
                            </span>
                            <span> <button onclick="delete_group(0)" class='btn btn-danger delete-group'>Xóa nhóm này</button></span>
                        </div>
                        <div class="group-content">
                            <div class="form-group" style='position:relative;'>
                                <div id="fquestion-0">
                                    <div class="box-question">
                                        <label for="comment-0">Nội dung câu hỏi:</label>
                                        <span> <button onclick="delete_question(0,0)" class='btn btn-danger delete-group' href="#">Xóa câu này</button></span>
                                        <textarea required name="question_title[]" class="form-control" rows="5" id="comment-0"></textarea>

                                    </div>
                                </div>
                                <div id='show_question-0'></div>
                                <input type="hidden" id="question_number-0" name="question_number[]" value="1">
                            </div>
                            <button type='button' class='btn btn-primary pqt-btn full' onclick='add_question(0);'>Thêm câu hỏi mới</button>
                            <span>Cho phép người dùng thêm ý kiến<span>
                                    <div>
                                        <input type="hidden" name="vote_0" value="0">
                                        <input value="1" name="vote_0" checked type="checkbox" id="cbx" style="display:none" />
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
                <div id='show_group'></div>
                <button type='button' class='btn btn-success pqt-btn full' id='add_group' href="#">Thêm nhóm câu hỏi mới</button>

                <button class='btn btn-primary pqt-btn full' name='submit' type='submit'>Tiến hành tạo khảo sát</button>
        </form>
    </div>

</div>
</div>

<?php include '../footer.php' ?>

<script>
    // Add, Delete Group 
    var id_group = 0;
    var id_question = 0;
    $("#add_group").click(function() {
        id_group++;
        id_question++
        $('<div id="fgroup-' + id_group + '"><br /><h3> Nhóm câu hỏi </h3><div class="group">  <div class="group-title">  <span>    <div class="col-xs-4"> <label for="ex' + id_group + '">Tiêu đề nhóm câu khảo sát.</label> <input class="form-control" required name="group_title[]" id="ex' + id_group + '" type="text"> </div>  </span> <span> <button class="btn btn-danger delete-group" onclick="delete_group(' + id_group + ')" >Xóa nhóm này</button></span> </div> <div class="group-content"> <div class="form-group" style="position:relative;"> <div id="fquestion-' + id_question + '"> <div class="box-question"> <label for="comment-' + id_question + '">Nội dung câu hỏi:</label> <span> <button onclick="delete_question(' + id_question + ',' + id_group + ')" class="btn btn-danger delete-group" >Xóa câu này</button></span> <textarea required name="question_title[]" class="form-control" rows="5" id="comment-' + id_question + '"></textarea> </div> </div> <input type="hidden" id="question_number-' + id_group + '" name="question_number[]" value="1"> <div id="show_question-' + id_group + '"></div>  </div> <button type="button" class="btn btn-primary pqt-btn" onclick="add_question(' + id_group + ');">Thêm câu hỏi mới</button> <span>Cho phép người dùng thêm ý kiến<span> <div> <input type="hidden" name="vote_' + id_group + '" value="0"> <input value="1" checked name="vote_' + id_group + '" type="checkbox" id="cbx-' + id_group + '" style="display:none" /> <label for="cbx-' + id_group + '" class="toggle"> <span> <svg width="10px" height="10px" viewBox="0 0 10 10"> <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>  </svg> </span> </label>  </div> </div> </div></div> <style>   #cbx-' + id_group + ':checked + .toggle:before { background: #52d66b; } #cbx-' + id_group + ':checked + .toggle span { transform: translateX(18px); } #cbx-' + id_group + ':checked + .toggle span path {   stroke: #52d66b;   stroke-dasharray: 25;   stroke-dashoffset: 25; } </style>').insertBefore("#show_group");
    });

    function delete_group(id) {
        if (id < 0) id = 0;
        else {
            $("#fgroup-" + id + "").remove();

        }
    }


    // Add, Delete Question 

    var question_number = 0;


    function add_question(id) {
        id_question++;
        question_number = $("#question_number-" + id + "").val();
        question_number++;
        $("#question_number-" + id + "").val(question_number);
        $('<div id="fquestion-' + id_question + '"><div class="box-question" ><label for="comment-' + id_question + '">Nội dung câu hỏi:</label> <span> <button class="btn btn-danger delete-group" onclick="delete_question(' + id_question + ',' + id_group + ')">Xóa câu này</button></span>  <textarea name="question_title[]" class="form-control" rows="5" id="comment-' + id_question + '"></textarea></div></div>').insertBefore("#show_question-" + id + "");
    };

    function delete_question(id, id_group) {
        if (id < 0) id = 0;
        else {
            question_number = $("#question_number-" + id_group + "").val();
            question_number--;
            $("#question_number-" + id_group + "").val(question_number);


            $("#fquestion-" + id + "").remove();

        }
    }
</script>


<?php
if (isset($_POST['submit'])) {
    $count = 0;
    $k = 0;
    $surveytitle = $_POST['survey_title'];
    $stringSQL = "insert INTO survey(survey_title,survey_group,date,vote,score) values('" . $surveytitle . "','',now(),0,0)";
    $query = mysqli_query($conn, $stringSQL);
    if (!$query) {
        echo '<script>
    swal("Lỗi !!!", "Có lỗi khi thêm Thảo sát", "error");
</script>';
        exit;
    } else {
        // get id survey
        $idsurvey = mysqli_insert_id($conn);


        $group_title = array_values($_POST['group_title']);
        // $vote_group = array_values($_POST['vote']);
        $item = 0;
        $vote_group = array();
        foreach ($_POST['group_title'] as $key => $value) {

            while (!isset($_POST["vote_$item"])) {
                $item++;
            }
            if (isset($_POST["vote_$item"])) {
                $vote_group[$key] = $_POST["vote_$item"];
                $item++;
            }
        }


        $question_title = array_values($_POST['question_title']);
        foreach ($_POST['question_number'] as $number_question) {

            // insert groups
            $content_group = $group_title[$k];
            $votestate = $vote_group[$k];
            $stringSQL = "insert INTO survey_groups(group_title,date,group_question,vote) values('" . $content_group . "',now(),''," . $votestate . ")";
            $query = mysqli_query($conn, $stringSQL);
            if (!$query) {
                echo '<script>
            swal("Lỗi !!!", "Có lỗi khi thêm Tên Groups", "error");
        </script>';
                exit;
            } else {
                // Fetch id group
                $idgroup = mysqli_insert_id($conn);

                for ($i = $count; $i < $number_question + $count; $i++) {
                    $content_question = $question_title[$i];
                    $stringSQL = "insert INTO survey_questions(question_title,date) values('" . $content_question . "',now())";
                    $query = mysqli_query($conn, $stringSQL);


                    if (!$query) {
                        echo '<script> swal("Lỗi !!!", "Có lỗi khi thêm Câu hỏi", "error");  </script>';
                        exit;
                    } else {
                        // get id questions
                        $id_question = mysqli_insert_id($conn);
                        $stringSQL = "update survey_groups set group_question = CONCAT(group_question, '" . $id_question . "','-pqt-') where group_id = " . $idgroup . "";
                        $query = mysqli_query($conn, $stringSQL);
                    }
                }

                $stringSQL = "update survey set survey_group = CONCAT(survey_group, '" . $idgroup . "','-pqt-') where survey_id = " . $idsurvey . "";
                $query = mysqli_query($conn, $stringSQL);
            }
           
            $count = $number_question;
            $k++;
        }
        $here = "<a href='".$baseurl."/survey/edit.php?survey_id=".$idsurvey."'>Xem tại đây</a>";
        echo '<script> swal({title: "Thành công !!!",html:true,text: "Thêm khảo sát thành công!!!\n '.$here.'", type:"success"});  </script>';

        
    }
}
?> 