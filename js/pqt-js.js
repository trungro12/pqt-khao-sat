// Select JS
function delete_survey(id) {
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
            url: "../survey/delete.php",
            type: "POST",
            data: {
                id: ids
            },
            success: function (data) {
                $("#survey-" + ids + "").remove();
                swal("Done!", "Xóa thành công!", "success");

            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error!", "Lỗi khi xóa, hãy thử lại sau!", "error");
            }
        });
    });

}