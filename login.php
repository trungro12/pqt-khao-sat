<?php include 'header.php';
if (is_admin()) {
    header("Location: " . $baseurl);
}

?>
<div class="introduce">
<?php
 if(only_survey !== null && only_survey === 1)
 {
    echo ' <h3>Hệ thống khảo sát Online cho Hội Sinh Viên Tỉnh Đồng Nai</h3>
    <p class="des">Một phần mềm giúp thu thập, đánh giá chất lượng, ý kiến của từng người trong một tập thể. Từ những
        ý kiến đó góp phần làm cho tập thể phát triển hơn.
    </p>';

 }
 else if(only_quiz !== null && only_quiz === 1)
 {
    echo ' <h3>Hệ thống thi trắc nghiệm Online</h3>
    <p class="des">Hệ thống giúp tự động tạo ra nhiều đề thi trắc nghiệm khác nhau từ những câu hỏi đã có. Tư đó hệ thống tính toán và cho ra đợt thi trắc nghiệm với điểm số được tính chính xác nhất.
    </p>';
 }
 else
 {
echo ' <h3>Phần mềm khảo sát và trắc nghiệm miễn phí</h3>
<p class="des">Một phần mềm giúp thu thập, đánh giá chất lượng, ý kiến của từng người trong một tập thể. Từ những
    ý kiến đó góp phần làm cho tập thể phát triển hơn.
</p>';
 }

?>
</div>
<div class="pqt-form">
    <div class="pqt-title">
        <h2>Đăng Nhập</h2>
    </div>
    <div class="pqt-content">
        <form action="" method="POST">

            <label for="username" class="inp">
                <input name="username" id="username" type="text" placeholder="&nbsp;">
                <span class="label">Tài Khoản :</span>
                <span class="border"></span>
            </label>
            <br />
            <label style='margin-top : 20px;' for="password" class="inp">
                <input name="password" id="password" type="password" placeholder="&nbsp;">
                <span class="label">Mật Khẩu :</span>
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
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $stringsql = "Select * from admin where username='$username' and password='$password'";
    $query = mysqli_query($conn, $stringsql);
    if (mysqli_num_rows($query) == 0) {
        echo '<script> swal("Lỗi đăng nhập !!!", "Tên đăng nhập hoặc mật khẩu không đúng!", "error") </script>';
    } else {
        $data = mysqli_fetch_array($query);
        if ($username == $data['username'] && $password == $data['password']) {
            $_SESSION['username'] = $username;
            $go_link = "";
            if (only_survey !== null && only_survey === 1) {
                $go_link = "" . $baseurl . "/survey/admin.php";
            } else if (only_quiz !== null && only_quiz === 1 ) {
                $go_link = "" . $baseurl . "/quiz/admin.php";
            }
            echo '<script>
    swal("Thành công !!!", "Đăng nhập thành công, hệ thống sẽ chuyển bạn sang trang Quản trị!", "success");
    setTimeout(function() {
        window.location.href = "' . $go_link.'";
    }, 2000);
</script>';
        } else {
            echo '<script>
    swal("Lỗi !!!", "Đăng nhập không thành công!", "error");
</script>';
        }
    }
}
?>

<?php include 'footer.php' ?> 