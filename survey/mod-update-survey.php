<?php
include '../db/connect.php';
$idSurvey = $_POST['post'];
$comment =  $_POST['comment'];

$stringSQL = "update survey set survey_title = '" . $comment . "' where survey_id=" . $idSurvey . "";
 $query = mysqli_query($conn, $stringSQL);
?>