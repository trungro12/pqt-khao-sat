<?php
include '../db/connect.php';
$idQuiz = $_POST['post'];
$comment =  $_POST['comment'];

$stringSQL = "update quiz set quiz_title = '" . $comment . "' where quiz_id=" . $idQuiz . "";
 $query = mysqli_query($conn, $stringSQL);
?>