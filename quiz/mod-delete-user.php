
<?php 
include '../db/connect.php';
 // delete  question
$id = $_POST['id'];
 $stringSQL = "delete from quiz_user where user_id=".$id."";
 $query = mysqli_query($conn, $stringSQL);


?>