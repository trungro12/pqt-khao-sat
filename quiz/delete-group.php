<?php
if (isset($_POST['id_delete'])) {
    ?>

<script>
    <?php $id_delete = $_POST['id_delete'] ?>

    function action_delete_group() {
        if (id < 0) id = 0;
        else {
            swal({
                    title: "Bạn có muốn xóa không?",
                    text: "Một khi xóa, bạn không thể khôi phục lại!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        <?php
                        $delete_group = "delete survey_groups where group_id=" . $id_delete . "";
                        $query = mysqli_query($conn, $delete_group);
                        if ($query) {
                            ?>
                        $("#fgroup-" + id + "").remove();
                        swal("Xóa thành công !", {
                            icon: "success",
                        });
                        <?php

                    } else echo '<script> swal("Xóa không thành công !!!", "có lỗi trong quá trình xóa!!!", "error");  <\/script>';
                    ?>

                    } else {
                        swal("Đã hủy xóa!");
                    }
                });


        }
    }
    action_delete_group();
</script>


<?php

}

?> 