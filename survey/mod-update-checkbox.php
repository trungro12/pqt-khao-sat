<?php
include '../db/connect.php';
$idGroup = $_POST['post'];
$apply =  $_POST['apply'];

$stringSQL = "update survey_groups set vote = " . $apply . " where group_id=" . $idGroup . "";
 $query = mysqli_query($conn, $stringSQL);
?>