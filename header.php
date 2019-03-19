<?php
$dirhome = $_SERVER["DOCUMENT_ROOT"]."/pqt-khao-sat";
include $dirhome."/"."functions.php";
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
    <script src="<?php echo $baseurl; ?>/js/pqt-js.js"></script>
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
         <a class='btn btn-primary' href="<?php echo $baseurl; ?>/login.php"> Đăng nhập</a> 
        </div>
    </div>
    </header>
