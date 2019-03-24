<?php include 'header.php' ?>
<div class="introduce">
    <h3>Phần mềm khảo sát miễn phí</h3>
    <p class='des'>Một phần mềm giúp thu thập, đánh giá chất lượng, ý kiến của từng người trong một tập thể. Từ những
        ý kiến đó góp phần làm cho tập thể phát triển hơn.
    </p>
</div>
<div class="pqt-form">
    <div class="pqt-title">
        <h2>Đăng Nhập</h2>
    </div>
    <div class="pqt-content">
        <form action="" method="POST">
            <label for="username">Tài Khoản :</label>
            <input required="" type="text" name="username" id="username">
            <label for="password">Mật Khẩu :</label>
            <input required="" type="password" id="password" name="password">
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
            echo '<script> swal("Thành công !!!", "Đăng nhập thành công, hệ thống sẽ chuyển bạn sang trang Quản trị!", "success"); 
            setTimeout(function() {window.location.href= "'.$baseurl.'/survey/admin.php";},2000);
            
            </script>';
        } else {
            echo '<script>swal("Lỗi !!!", "Đăng nhập không thành công!", "error"); </script>';
        }
    }
}
?>

<?php include 'footer.php' ?> 