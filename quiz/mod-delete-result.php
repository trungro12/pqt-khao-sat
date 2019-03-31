
<?php 
include '../db/connect.php';
 // delete  question
$idPost = $_POST['id'];
$idGroup = $_POST['id_group'];
 $stringSQL = "delete from quiz_result where result_id=".$idPost."";
 $query = mysqli_query($conn, $stringSQL);

 $stringSQL = "update quiz_groups set group_result = REPLACE(group_result,'" . $idPost . "-pqt-','') where group_id=" . $idGroup . "";
 $query = mysqli_query($conn, $stringSQL);

?>