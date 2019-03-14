<?php include 'header.php' ?>
    <div class="page-content">
        <div class="container">
           <div class="survey-content">
           <div class="group">
               
               <div class="group-title">
               <span> 
                   
               <div class="col-xs-4">
                <label for="ex3">Tiêu đề nhóm câu khảo sát.</label>
                <input class="form-control" id="ex3" type="text">
                </div>
                </span>
               <span> <a class='btn btn-danger delete-group' href="#">Xóa nhóm này</a></span>
               </div>
               <div class="group-content">
               <div class="form-group" style='position:relative;'>
  <label for="comment">Nội dung câu hỏi:</label>
  <span> <a class='btn btn-danger delete-group' href="#">Xóa câu này</a></span>
  <textarea class="form-control" rows="5" id="comment"></textarea>
</div>


<a class='btn btn-primary pqt-btn' href="#">Thêm câu hỏi mới</a>
<span>Cho phép người dùng thêm ý kiến<span>
<div>
  <input type="checkbox" id="cbx" style="display:none"/>
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
           <a class='btn btn-success pqt-btn' href="#">Thêm nhóm câu hỏi mới</a>
           </div>
            
        </div>
    </div>


<?php include 'footer.php' ?>