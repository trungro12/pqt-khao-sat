<?php
// Turn off error reporting
error_reporting(0);
if(!isset($_SESSION)) session_start();

header('Content-Type: text/html; charset=utf-8');
$dirhome = $_SERVER['DOCUMENT_ROOT']."/pqt-khao-sat";
include $dirhome."/functions.php";
include $dirhome."/db/connect.php";
$baseurl = pqt_baseurl();
?>

<html lang="en" xmlns:m="http://www.w3.org/1998/Math/MathML">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/bootstrap/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="<?php echo $baseurl; ?>/bootstrap/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <link rel='stylesheet' href='<?php echo $baseurl; ?>/style.css'>
    <link href="<?php echo $baseurl; ?>/sweetalert/sweetalert.css" rel="stylesheet" />
    <script src="<?php echo $baseurl; ?>/sweetalert/sweetalert.min.js"></script>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->
    <script type="text/javascript">
MathJax.Hub.Config({
  jax: ["input/TeX","output/CommonHTML"],
  extensions: ["tex2jax.js","MathMenu.js","MathZoom.js", "AssistiveMML.js", "a11y/accessibility-menu.js"],
  TeX: {
    extensions: ["AMSmath.js","AMSsymbols.js","noErrors.js","noUndefined.js"]
  }
});
</script>
    <script src="<?php echo $baseurl; ?>/mathjax/MathJax.js?config=default"></script>

    <title><?php if(is_survey_panel()) echo "PQT - Survey Control Panel"; else echo "PQT" ?></title>
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
                echo "<a class='login btn btn-primary' href='".$baseurl."/admin.php'> ".$admin."</a> 
                <a class='login btn btn-primary' href='".$baseurl."/logout.php'> Đăng xuất</a> 
                ";
            }
            else if(isset($_SESSION['user_name']))
            {
                $user_exam = $_SESSION['user_name'];
                echo "<span class='login btn btn-primary' > ".$user_exam."</span> <a class='login btn btn-primary' href='".$baseurl."/logout.php'> Đăng xuất</a> ";
                
            }
            else
            {
                echo "<a class='login btn btn-primary' href='".$baseurl."/login.php'> Đăng nhập</a> ";
            }
        ?>


        </div>
    </div>
    </header>
