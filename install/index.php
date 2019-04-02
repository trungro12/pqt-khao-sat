<?php
if (!isset($_SESSION)) session_start();
header('Content-Type: text/html; charset=utf-8');
$dirhome = $_SERVER["DOCUMENT_ROOT"] . "/pqt-khao-sat";
include $dirhome . "/" . "functions.php";
$baseurl = pqt_baseurl();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <link rel='stylesheet' href='<?php echo $baseurl; ?>/style.css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <title>PQT</title>
</head>

<body>
    <header id='header' class='header'>
        <div class="top-bar">
            <div class='top-bar-brand'>
                <h1 id='logo'> <a href="<?php echo $baseurl; ?>">PQT</a> </h1>
            </div>
            <div class='top-bar-note'>
                <span>Hệ thống khảo sát miễn phí với nhiều tính năng hấp dẫn</span>
                <a class='login btn btn-primary' href="<?php echo $baseurl; ?>/login.php"> Đăng nhập</a>
            </div>
        </div>
    </header>
    <div class="old-form">
    <div class="pqt-form">
        <div class="pqt-title">
            <h2>Cài đặt, cấu hình kết nối tới Database</h2>
        </div>
      
        <div class="pqt-content">
            <form action="" method="POST">
                <label for="host">Host :</label>
                <input required="" type="text" value='localhost' name="db_host" id="db_host">
                <label for="db_username">Database username :</label>
                <input required="" type="text" name="db_username" id="db_username">
                <label for="db_password">Database password :</label>
                <input type="password" name="db_password" id="db_password">
                <label for="db_name">Database name :</label>
                <input required="" type="text" name="db_name" id="db_name">
                <label for="username">Tài Khoản Admin :</label>
                <input required="" type="text" name="username" id="username">
                <label for="password">Mật Khẩu Admin :</label>
                <input required="" type="password" id="password" name="password">
                <button type="submit" class="pqt-btn blue" name="submit">Cài đặt</button>
            </form>
        </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $db_host = $_POST['db_host'];
        $db_user = $_POST['db_username'];
        $db_password = $_POST['db_password'];
        $db_name = $_POST['db_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        mysqli_set_charset($conn, "UTF8");
        if (!$conn) {
            echo '<script>swal("Lỗi kết nối", "Có lỗi khi kết nối đếnn cơ sở dữ liệu", "error"); </script>';
        } else {

            $sql = "Create table IF NOT EXISTS survey(
                survey_id int primary key AUTO_INCREMENT,
                survey_title varchar(255) not null,
                survey_group varchar(255) not null,
                date TIMESTAMP,
                vote int,
                score float
                )
                ENGINE=InnoDB CHARACTER SET=utf8;";
            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng Survey thành công !!!";
            }

            $sql = "Create table IF NOT EXISTS survey_groups(
                    group_id int primary key AUTO_INCREMENT,
                    group_title varchar(255) not null,
                    date TIMESTAMP,
                    group_question varchar(100),
                    vote int,
                    custom_vote text
                    )
                    ENGINE=InnoDB CHARACTER SET=utf8;";
            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng groups thành công !!!";
            }


            $sql = "Create table IF NOT EXISTS survey_questions(
                        question_id int primary key AUTO_INCREMENT,
                        question_title varchar(255) not null,
                        vote int,
                        score float,
                        date TIMESTAMP
                        )
                        ENGINE=InnoDB CHARACTER SET=utf8;";
            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng questions thành công !!!";
            }


            $sql = "Create table IF NOT EXISTS quiz(
                quiz_id int primary key AUTO_INCREMENT,
                quiz_title longtext not null,
                quiz_group varchar(255) not null,
                date TIMESTAMP,
                time int,
                public tinyint
                )
                ENGINE=InnoDB CHARACTER SET=utf8;";
            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng Quiz thành công !!!";
            }

            $sql = "Create table IF NOT EXISTS quiz_groups(
                group_id int primary key AUTO_INCREMENT,
                group_title longtext not null,
                date TIMESTAMP,
                group_result text,
                true_result tinyint
                )
                ENGINE=InnoDB CHARACTER SET=utf8;";

            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng quiz_groups thành công !!!";
            }

            $sql = "Create table IF NOT EXISTS quiz_result(
                    result_id int primary key AUTO_INCREMENT,
                    result_title longtext not null,
                    date TIMESTAMP
                    )
                    ENGINE=InnoDB CHARACTER SET=utf8;";
            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng quiz_result thành công !!!";
            }

            $sql = "Create table IF NOT EXISTS quiz_user(
                user_id int primary key AUTO_INCREMENT,
                user_name varchar(255) not null,
                user_class varchar(255) not null,
                user_mssv varchar(255) not null,
                quiz_id int,
                score float,
                time_left int,
                date TIMESTAMP
                )
                ENGINE=InnoDB CHARACTER SET=utf8;";
            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng quiz_user thành công !!!";
            }

            $sql = "Create table IF NOT EXISTS admin(
                        id int primary key AUTO_INCREMENT,
                        username varchar(50) unique not null,
                        password varchar(50) not null,
                        date TIMESTAMP
                        )
                        ENGINE=InnoDB CHARACTER SET=utf8;";
            if (mysqli_query($conn, $sql)) {
                echo "Tạo bảng admin thành công !!!";
                $sql = "INSERT INTO admin(username,password,date) values('$username','$password',now())";
                if (!mysqli_query($conn, $sql)) {
                    echo '<script>swal("Lỗi !!!", "Có lỗi khi tạo Admin", "error"); </script>';
                }
            }
            $fp = fopen('../db/connect.php', 'w');
            fwrite($fp, '<?php $db_host = "' . $db_host . '";
            $db_user = "' . $db_user . '";
            $db_password = "' . $db_password . '";
            $db_name = "' . $db_name . '";
            $conn = mysqli_connect($db_host,$db_user,$db_password,$db_name);
            mysqli_set_charset($conn, "UTF8");
            if(!$conn)
            {
                header("Location: install/index.php");
            } ?>');
            fclose($fp);
            echo '<script>
        swal("Thành công !!!", "Chúc mừng bạn đã cài đặt thành công !! Hãy xóa thư mục install hoặc di chuyển thư mục install sang nơi khác.", "success");
    </script>';
        }
    }
    ?> 