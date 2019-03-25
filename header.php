<?php
if(!isset($_SESSION)) session_start();

header('Content-Type: text/html; charset=utf-8');
$dirhome = $_SERVER["DOCUMENT_ROOT"]."/pqt-khao-sat";
include $dirhome."/"."functions.php";
include $dirhome."/db\/"."connect.php";
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
        <span class='notice'>Hệ thống khảo sát và trắc nghiệm miễn phí</span>
        
        <?php
            if(isset($_SESSION['username']))
            {
                $admin = $_SESSION['username'];
                echo "<a class='login btn btn-primary' href='".$baseurl."/survey/admin.php'> ".$admin."</a> 
                <a class='login btn btn-primary' href='".$baseurl."/logout.php'> Đăng xuất</a> 
                ";
            }
            else
            {
                echo "<a class='login btn btn-primary' href='".$baseurl."/login.php'> Đăng nhập</a> ";
            }
        ?>


        </div>
    </div>
    </header>
