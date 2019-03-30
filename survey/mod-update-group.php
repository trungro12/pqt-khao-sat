<?php
include '../db/connect.php';
$id_group = $_POST['post'];
$comment =  $_POST['comment'];

$stringSQL = "update survey_groups set group_title = '" . $comment . "' where group_id=" . $id_group . "";
 $query = mysqli_query($conn, $stringSQL);
?>