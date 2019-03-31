<?php
include '../db/connect.php';
$idQuiz = $_POST['post'];
$apply =  $_POST['apply'];

$stringSQL = "update quiz set public = " . $apply . " where quiz_id=" . $idQuiz . "";
 $query = mysqli_query($conn, $stringSQL);
?>