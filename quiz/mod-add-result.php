
<?php 
include '../db/connect.php';
 // update -> insert question
$idGroup = $_POST['id'];
 $stringSQL = "insert into quiz_result(result_title,date) values('',now())";
 $query = mysqli_query($conn, $stringSQL);
 $id_result = mysqli_insert_id($conn);

 $stringSQL = "update quiz_groups set group_result = CONCAT(group_result,'" . $id_result . "','-pqt-') where group_id= " . $idGroup . "";
 $query = mysqli_query($conn, $stringSQL);


echo $id_result;

?>