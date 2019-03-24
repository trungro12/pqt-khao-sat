<?php include '../header.php';
pqt_permission();
?>
<div class="page-content">
    <div class="container">
        <div class="survey-content">
            <form action="" method="POST">
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
                            <span> <button onclick="delete_group(0)" class='btn btn-danger delete-group' href="#">Xóa nhóm này</button></span>
                        </div>
                        <div class="group-content">
                            <div class="form-group" style='position:relative;'>
                                <div id="fquestion-0">
                                    <div class="box-question">
                                        <label for="comment-0">Nội dung câu hỏi:</label>
                                        <span> <button onclick="delete_question(0)" class='btn btn-danger delete-group' href="#">Xóa câu này</button></span>
                                        <textarea required name="question_title[]" class="form-control" rows="5" id="comment-0"></textarea>
                                    </div>
                                </div>
                                <div id='show_question-0'></div>
                            </div>
                            <button class='btn btn-primary pqt-btn full' onclick='add_question(0);'>Thêm câu hỏi mới</button>
                            <span>Cho phép người dùng thêm ý kiến<span>
                                    <div>
                                        <input name="vote[]" type="checkbox" id="cbx" style="display:none" />
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
                <button class='btn btn-success pqt-btn full' id='add_group' href="#">Thêm nhóm câu hỏi mới</button>

                <button class='btn btn-primary pqt-btn full' type='submit' href="#">Lưu</button>
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
        $('<div id="fgroup-' + id_group + '"><br /><h3> Nhóm câu hỏi </h3><div class="group">  <div class="group-title">  <span>    <div class="col-xs-4"> <label for="ex' + id_group + '">Tiêu đề nhóm câu khảo sát.</label> <input class="form-control" required name="group_title[]" id="ex' + id_group + '" type="text"> </div>  </span> <span> <button class="btn btn-danger delete-group" onclick="delete_group(' + id_group + ')" >Xóa nhóm này</button></span> </div> <div class="group-content"> <div class="form-group" style="position:relative;"> <div id="fquestion-' + id_question + '"> <div class="box-question"> <label for="comment-' + id_question + '">Nội dung câu hỏi:</label> <span> <button onclick="delete_question(' + id_question + ')" class="btn btn-danger delete-group" >Xóa câu này</button></span> <textarea required name="question_title[]" class="form-control" rows="5" id="comment-' + id_question + '"></textarea> </div> </div>  <div id="show_question-' + id_group + '"></div>  </div> <button class="btn btn-primary pqt-btn" onclick="add_question(' + id_group + ');">Thêm câu hỏi mới</button> <span>Cho phép người dùng thêm ý kiến<span> <div> <input name="vote[]" type="checkbox" id="cbx-' + id_group + '" style="display:none" /> <label for="cbx-' + id_group + '" class="toggle"> <span> <svg width="10px" height="10px" viewBox="0 0 10 10"> <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>  </svg> </span> </label>  </div> </div> </div></div> <style>   #cbx-' + id_group + ':checked + .toggle:before { background: #52d66b; } #cbx-' + id_group + ':checked + .toggle span { transform: translateX(18px); } #cbx-' + id_group + ':checked + .toggle span path {   stroke: #52d66b;   stroke-dasharray: 25;   stroke-dashoffset: 25; } </style>').insertBefore("#show_group");
    });

    function delete_group(id) {
        if (id < 0) id = 0;
        else {
            $("#fgroup-" + id + "").remove();

        }
    }


    // Add, Delete Question 



    function add_question(id) {
        id_question++;
        $('<div id="fquestion-' + id_question + '"><div class="box-question" ><label for="comment-' + id_question + '">Nội dung câu hỏi:</label> <span> <button class="btn btn-danger delete-group" onclick="delete_question(' + id_question + ')">Xóa câu này</button></span>  <textarea name="question_title[]" class="form-control" rows="5" id="comment-' + id_question + '"></textarea></div></div>').insertBefore("#show_question-" + id + "");
    };

    function delete_question(id) {
        if (id < 0) id = 0;
        else {
            $("#fquestion-" + id + "").remove();

        }
    }
</script> 


<?php
if(isset($_POST['submit']))
{
    $group_array = array_values($_POST['group_title[]']);
    $question_array = array_values($_POST['question_title[]']);
    $vote_array = array_values($_POST['vote[]']);
    $count = 0;
    foreach($group_array as $i)
    {

        $count++;
    }
}
?>