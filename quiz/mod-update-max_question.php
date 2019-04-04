<?php
include '../db/connect.php';
$post = $_POST['post'];
$comment =  $_POST['comment'];

$stringSQL = "update quiz set max_question = '" . $comment . "' where quiz_id=" . $post . "";
 $query = mysqli_query($conn, $stringSQL);
?>