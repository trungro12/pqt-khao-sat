<?php include '../header.php';
?>
<div class="quiz-list">
    <ul>
        <!-- <li id="s-fgroup-0-li"><a id="s-fgroup-0" href="#fgroup-0">Câu hỏi</a></li> -->
        <p id="show-list"></p>
    </ul>
</div>
<?php
if (isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];



    // System
    $stringSQL = "select * from quiz where quiz_id=" . $quiz_id;
    $dataQuiz = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
    if (!$dataQuiz) {
        echo '<script> swal("Lỗi !!!", "Đường dẫn sai hoặc đã bị xóa!!!", "error");  </script>';
        exit;
    }

    if (!is_admin()) {
        if ($dataQuiz['public'] < 1) {
            echo '<script> swal("Rất tiếc !!!", "Bạn không có quyền xem trang này!!!", "error");  </script>';
            exit;
        }
    }

    $last_id_result = 0;
    $time_exam = $dataQuiz['time'];
    ?>
<div class="page-content">
    <div class="container">
        <br />
        <?php
        if (isset($_SESSION['user_id']) || is_admin()) {
            $time_left = 0;
            $userid = $_SESSION['user_id'];
            if (!is_admin()) {
                    $stringSQL = "select * from quiz_user where quiz_id=" . $quiz_id . " and user_id=" . $userid;
                    $data = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                   
                    if ($data) {
                            $time_left = isset($data['time_left']) ? $data['time_left'] : $dataQuiz['time'];
                        } else {
                            echo '<script> swal("Rất tiếc !!!", "Bạn không có quyền xem trang này!!!", "error");  </script>';
                            exit;
                        }
                }
            // Check User test exam
            if (isset($_SESSION['user_score'])) {
                if ($_SESSION['user_score'] > 0) {
                    echo '
                    <script>
                    var comfi = confirm("Rất tiếc! Bạn đã thi rồi, Để thi lại hãy liên hệ với quản trị viên !!");
                    </script>
                    ';
                    echo '<div class="introduce">
                    <div class="form-group" style="position:relative;">
                        <div class="col-xs-12">
                            <h2>Điểm của thí sinh ' . $_SESSION['user_name'] . ' là <b style="color:#000000">' . $_SESSION['user_score'] . '</b> </h2>
                        </div>
                        <br />
                 
                    </div>
                </div>';
                    exit;
                }
            }

            if (!is_admin()) {
                echo '
            <span style="position: fixed;
            top: 0;
            left: 30%;
            background: #e81616;
            z-index: 99999999;
            font-weight: 600;
            color: #fff;
            padding: 5px;
            border-radius: 7px;
            opacity: .8;
            font-size: 13px;" id="time-show"> </span>
            <script>
            var phut = ' .  $time_left . '+1;
            var giay = 0;

            function time_exam(){
                
                $("#time-show").html("Thời gian còn lại : " + phut + ": "+giay);
                var settime = setTimeout("time_exam()",1000);
                giay--;
                var userid = '.$userid.';
                if(giay == -1)
                {
                    phut -= 1;
                    giay = 59;
                    $.ajax({
                        type: "POST",
                        url: "../quiz/mod-update-time.php",
                        data: {
                            userid: userid,
                            apply: phut
                        },
                        success: function(data) {

                        }
                    });
                }
                if(phut == -1)
                {
                    $("#submit").click();
                    clearTimeout(settime);
                }
            }
            time_exam();
            </script>
            
            ';
            }
            ?>
        <!-- Content -->
        <!-- html -->
        <form action="" method="POST">
            <div class="introduce">
                <div class="form-group" style='position:relative;'>
                    <div class="col-xs-12">
                        <label for="quiz_title" style='text-align:center;font-weight: bold;font-size: 25px;'><?php echo $dataQuiz['quiz_title']; ?></label>
                        <input required value="<?php echo $dataQuiz['quiz_title']; ?>" name="quiz_title" class="form-control" id="quiz_title" style="display:none" type="text">
                    </div>
                    <br />
                    <?php
                    if (is_admin()) {

                        ?>
                    <a href="<?php echo $baseurl; ?>/quiz/quiz-user.php?quiz_id=<?php echo $quiz_id; ?>" class='btn btn-primary'>Danh sách dự thi</a>
                    <a href="<?php echo $baseurl; ?>/quiz/edit.php?quiz_id=<?php echo $quiz_id; ?>" class='btn btn-primary'>Sửa</a>
                    <button id="delete_quiz" type="button" class='btn btn-danger'>Xóa</button>
                    <?php

                }
                ?>
                </div>
            </div>
            <!-- end update Quiz title -->
            <?php
            if (is_admin()) {
                ?>

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


            <?php

        }
        ?>


            <!-- Update result, insert result************************************************************** -->
            <div class="survey-content">
                <?php
                $array_group = explode("-pqt-", $dataQuiz['quiz_group']);

                // RAndom
                shuffle($array_group);

                foreach ($array_group as $id_group) {
                    if ($id_group != "" || $id_group != null) {
                        $stringSQL = "select * from quiz_groups where group_id=" . $id_group . "";
                        $dataGroup = mysqli_fetch_array(mysqli_query($conn, $stringSQL));

                        ?>
                <!-- html -->
                <br />
                <div id='fgroup-<?php echo $id_group; ?>'>
                    <script>
                        $('<li id="s-fgroup-<?php echo $id_group; ?>-li"><a id="s-fgroup-<?php echo $id_group; ?>" href="#fgroup-<?php echo $id_group; ?>">Câu hỏi</a></li>').insertBefore("#show-list");
                    </script>
                    <div class="group">
                        <div class="group-title">
                            <span>
                                <div class="col-xs-4">
                                    <!-- <label for="ex<?php echo $id_group; ?>">Tiêu đề câu hỏi.</label> -->
                                    <b><?php echo $dataGroup['group_title']; ?></b>
                                    <input required value="<?php echo $dataGroup['group_title']; ?>" name="group_title_<?php echo $id_group; ?>" id="ex<?php echo $id_group; ?>" class="form-control" style="display:none;" type="text">

                                </div>
                            </span>
                        </div>
                        <div class="group-content">

                            <!-- List Result -->
                            <div class="form-group" style='position:relative;'>
                                <table>
                                    <tr>
                                        <th>Nội dung kết quả</th>
                                        <th>Kết quả đúng là ?</th>
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
                                                    <b style="max-width: 1000px;" required name="result_title_<?php echo $id_result; ?>" class="form-control" rows="5" id="comment-<?php echo $id_result; ?>"><?php echo trim($dataResult['result_title']); ?></b>

                                                </div>
                                            </td>
                                            <td>
                                                <!-- True REsult -->
                                                <div class="cntr">
                                                    <label for="true_<?php echo $id_result; ?>" class="radio">
                                                        <input type="radio" name="true_<?php echo $id_group; ?>" id="true_<?php echo $id_result; ?>" value="<?php echo $id_result; ?>" class="hidden" />
                                                        <span class="label"></span>
                                                    </label>
                                                </div>

                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php

                                }
                            }
                            ?>

                                </table>
                            </div>

                            <input type="hidden" id="result_number-<?php echo $id_group; ?>" name="result_number[]" value="<?php echo $result_count; ?>">

                        </div>
                    </div>
                </div>

                <?php

            }
        }

        ?>

                <div id='show_group'></div>
                <?php
                if (!is_admin()) {
                    ?>
                <button class='btn btn-primary pqt-btn full' id="submit" name='submit' type='submit'>Gửi</button>
                <?php

            }

            ?>

        </form>


        <?php
        if (isset($_POST['submit'])) {
            $array_group = explode("-pqt-", $dataQuiz['quiz_group']);
            $user_score = 0;
            $true = 0;
            $number_question = 0;
            foreach ($array_group as $group) {
                if ($group != null || $group != "") {
                    $number_question++;
                    if (isset($_POST["true_$group"])) {
                        $stringSQL = "select * from quiz_groups where group_id=" . $group . "";
                        $datag = mysqli_fetch_array(mysqli_query($conn, $stringSQL));
                        if ($datag['true_result'] == $_POST["true_$group"]) {
                            $true++;
                        }
                    }
                }
            }
            $user_score = $true / $number_question * 100;
            $user_score_10 = $user_score / 10;
            $user_mssv =  $_SESSION['user_mssv'];
            $user_class = $_SESSION['user_class'];
            $stringSQL = "update quiz_user set score=" . $user_score_10 . "    where LOWER(user_class)='" . strtolower($user_class) . "' AND user_mssv='" . $user_mssv . "' ";
            $query = mysqli_query($conn, $stringSQL);
            if (!$query) echo '<script> swal("Error !!!", "Có lỗi khi gửi !!. ' . mysqli_error($conn) . ' ", "error"); </script>';
            else {
                $_SESSION['user_score'] = $user_score_10;

                echo '<script>swal("Done !!!", "Gửi bài thành công!", "success");</script>';
            }
        }

        ?>





    </div>


    <?php

} else {

    ?>
    <!-- Login -->
    <div class="pqt-form">
        <div class="pqt-title">
            <h2>Đăng Nhập Tham dự bài thi</h2>
        </div>
        <div class="pqt-content">
            <b style="color:red">Thời gian làm bài : <?php echo $time_exam . " phút"; ?>, Sau khi đăng nhập, hệ thống sẽ bắt đầu tính giờ làm bài</b>
            <form action="" method="POST">
                <label for="user_mssv" class="inp">
                    <input name="user_mssv" id="user_mssv" type="text" placeholder="&nbsp;">
                    <span class="label">Mã số sinh viên :</span>
                    <span class="border"></span>
                </label>
                <br />
                <label style='margin-top : 20px;' for="user_class" class="inp">
                    <input name="user_class" id="user_class" type="text" placeholder="&nbsp;">
                    <span class="label">Lớp</span>
                    <span class="border"></span>
                </label>

                <!-- <label for="username">Tài Khoản :</label>
            <input required="" type="text" name="username" id="username">
            <label for="password">Mật Khẩu :</label>
            <input required="" type="password" id="password" name="password"> -->
                <button type="submit" class="pqt-btn blue" name="submit">Đăng Nhập</button>
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $mssv = $_POST['user_mssv'];
        $class = $_POST['user_class'];
        // User
        $stringSQL = "select * from quiz_user where LOWER(user_class) = '" . strtolower($class) . "' and user_mssv = '" . $mssv . "' ";
        $query = mysqli_query($conn, $stringSQL);
        $row = mysqli_num_rows($query);
        $dataU = mysqli_fetch_array($query);
        if ($row == 0) {
            echo '<script>swal("Lỗi !!!", "Sai mã số sinh viên hoặc lớp, vui lòng thử lại!", "error"); </script>';
        } else {
            $_SESSION['user_name'] = $dataU['user_name'];
            $_SESSION['user_id'] = $dataU['user_id'];
            $_SESSION['user_mssv'] = $dataU['user_mssv'];
            $_SESSION['user_class'] = $dataU['user_class'];
            $_SESSION['user_score'] = $dataU['score'];
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}
?>
    <?php

} else {
    echo '<script> swal("Lỗi !!!", "Đường dẫn sai hoặc không tồn tại!!!", "error");  </script>';
}
?>
</div>
</div>




<?php include '../footer.php' ?> 