<?php
include '../db/connect.php';
$isQuestion = $_POST['post'];
$comment =  $_POST['comment'];

$stringSQL = "update survey_questions set question_title = '" . $comment . "' where question_id=" . $isQuestion . "";
 $query = mysqli_query($conn, $stringSQL);
?>