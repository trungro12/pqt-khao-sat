
<?php 
include '../db/connect.php';
 // update -> insert question
$id = $_POST['id'];
 $stringSQL = "insert into quiz_result(user_name,user_class,user_mssv,quiz_id) values('','','',".$id.")";
 $query = mysqli_query($conn, $stringSQL);
 $id_result = mysqli_insert_id($conn);

echo $id_result;

?>