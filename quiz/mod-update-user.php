<?php
include '../db/connect.php';
$isResult = $_POST['post'];
$comment =  $_POST['comment'];
$columns = $_POST['col'];
if(isset($_POST['isnum']))
{
    $stringSQL = "update quiz_user set ".$columns." = " . $comment . " where user_id=" . $isResult . "";
}
else $stringSQL = "update quiz_user set ".$columns." = '" . $comment . "' where user_id=" . $isResult . "";
 $query = mysqli_query($conn, $stringSQL);
?>