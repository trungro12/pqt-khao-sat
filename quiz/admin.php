<?php include '../header.php';
pqt_permission();
?>


<div class="page-content">
<div class="introduce">
<h2>quiz Control Panel</h2>
</div>
    <a class='btn btn-success pqt-btn' href="<?php echo $baseurl; ?>/quiz/add.php">Tạo trắc nghiệm mới</a>
    <div class="container">
        <div class="row quiz-content">
            <?php
            $stringSQL = "select * from quiz";
            $query = mysqli_query($conn, $stringSQL);
            while ($data = mysqli_fetch_array($query)) {
                    ?>

            <div class="col-xs-6 col-md-3 text-center item" id="quiz-<?php echo $data['quiz_id'];?>" >
                <a href="<?php echo $baseurl; ?>/quiz/view.php?quiz_id=<?php echo $data['quiz_id']; ?>">
                    <img src="<?php echo $baseurl; ?>/images/survey-icon-blue.png" alt="#">
                    <p class='quiz-name'><?php echo $data['quiz_title']." (".$data['time']." phút)";?></p>
                </a>
                <a href="<?php echo $baseurl; ?>/quiz/edit.php?quiz_id=<?php echo $data['quiz_id'];?>" class='btn btn-info'>Sửa</a>
                <a href="<?php echo $baseurl; ?>/quiz/view.php?quiz_id=<?php echo $data['quiz_id'];?>" class='btn btn-primary'>Xem</a>
                <button onclick="delete_quiz(<?php echo $data['quiz_id'];?>)" class='btn btn-danger'>Xóa</button>
            </div>


            <?php
        }
    ?>

        </div>
    </div>
</div>

<script>
function delete_quiz(id) {
    var ids = id;
    swal({
        title: "Bạn có chắc muốn xóa không?",
        text: "Một khi đã xóa là không thể khôi phục lại!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url: "../quiz/delete.php",
            type: "POST",
            data: {
                id: ids
            },
            success: function (data) {
                $("#quiz-" + ids + "").remove();
                swal("Done!", "Xóa thành công!", "success");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error!", "Lỗi khi xóa, hãy thử lại sau!", "error");
            }
        });
    });

}
</script>
<?php include '../footer.php' ?> 