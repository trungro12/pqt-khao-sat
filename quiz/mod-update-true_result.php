<?php
include '../db/connect.php';
$id_result = $_POST['id_result'];
$id_group =  $_POST['id_group'];

$stringSQL = "update quiz_groups set true_result = " . $id_result . " where group_id=" . $id_group . "";
 $query = mysqli_query($conn, $stringSQL);
?>