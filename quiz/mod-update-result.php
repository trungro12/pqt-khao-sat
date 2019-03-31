<?php
include '../db/connect.php';
$isResult = $_POST['post'];
$comment =  $_POST['comment'];

$stringSQL = "update quiz_result set result_title = '" . $comment . "' where result_id=" . $isResult . "";
 $query = mysqli_query($conn, $stringSQL);
?>