<?php include '../header.php' ?>
<div class="page-content">
    <div class="container">
        <div class="survey-content">

            <div id='fgroup-0'>
                <div class="group">
                    <div class="group-title">
                        <span>
                            <div class="col-xs-4">
                                <label for="ex3">Tiêu đề nhóm câu khảo sát.</label>
                                <input class="form-control" id="ex3" type="text">
                            </div>
                        </span>
                        <span> <button onclick="delete_group(0)" class='btn btn-danger delete-group' href="#">Xóa nhóm này</button></span>
                    </div>
                    <div class="group-content">
                        <div class="form-group" style='position:relative;'>
                            <div id="fquestion-0">
                            <div class="box-question">
                                <label for="comment">Nội dung câu hỏi:</label>
                                <span> <button onclick="delete_question(0)" class='btn btn-danger delete-group' href="#">Xóa câu này</button></span>
                                <textarea class="form-control" rows="5" id="comment"></textarea>
                            </div>
                            </div>
                            <div id='show_question-0'></div>
                        </div>
                        <button class='btn btn-primary pqt-btn' onclick='add_question(0);'>Thêm câu hỏi mới</button>
                        <span>Cho phép người dùng thêm ý kiến<span>
                                <div>
                                    <input type="checkbox" id="cbx" style="display:none" />
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
            <button class='btn btn-success pqt-btn' id='add_group' href="#">Thêm nhóm câu hỏi mới</button>
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
        $('<div id="fgroup-' + id_group + '"><br /><div class="group">  <div class="group-title">  <span>    <div class="col-xs-4"> <label for="ex3">Tiêu đề nhóm câu khảo sát.</label> <input class="form-control" id="ex3" type="text"> </div>  </span> <span> <button class="btn btn-danger delete-group" onclick="delete_group('+id_group+')" >Xóa nhóm này</button></span> </div> <div class="group-content"> <div class="form-group" style="position:relative;"> <div id="fquestion-' + id_question + '"> <div class="box-question"> <label for="comment">Nội dung câu hỏi:</label> <span> <button onclick="delete_question(' + id_question + ')" class="btn btn-danger delete-group" >Xóa câu này</button></span> <textarea class="form-control" rows="5" id="comment"></textarea> </div> </div>  <div id="show_question-'+id_group+'"></div>  </div> <button class="btn btn-primary pqt-btn" onclick="add_question('+id_group+');">Thêm câu hỏi mới</button> <span>Cho phép người dùng thêm ý kiến<span> <div> <input type="checkbox" id="cbx" style="display:none" /> <label for="cbx" class="toggle"> <span> <svg width="10px" height="10px" viewBox="0 0 10 10"> <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>  </svg> </span> </label>  </div> </div> </div></div>').insertBefore("#show_group"); });

    function delete_group(id) {
        if (id < 0) id = 0;
        else {
            $("#fgroup-" + id + "").remove();
           
        }
    }


    // Add, Delete Question 

  

    function add_question(id) {
        id_question++;
        $('<div id="fquestion-' + id_question + '"><div class="box-question" ><label for="comment">Nội dung câu hỏi:</label> <span> <button class="btn btn-danger delete-group" onclick="delete_question(' + id_question + ')">Xóa câu này</button></span>  <textarea class="form-control" rows="5" id="comment"></textarea></div></div>').insertBefore("#show_question-" + id + "");
    };

    function delete_question(id) {
        if (id < 0) id = 0;
        else {
            $("#fquestion-" + id + "").remove();
           
        }
    }
</script> 