<?php
include '../db/connect.php';
$userid = $_POST['userid'];
$apply =  $_POST['apply'];

$stringSQL = "update quiz_user set time_left = '" . $apply . "' where user_id=" . $userid . "";
 $query = mysqli_query($conn, $stringSQL);
?>