
<?php 
include '../db/connect.php';
 // delete  question, not completed
$idGroup = $_POST['id'];
 $stringSQL = "delete from survey_groups where group_id=".$idPost."";
 $query = mysqli_query($conn, $stringSQL);

 $stringSQL = "update survey_groups set group_question = REPLACE(group_question,'" . $idPost . "-pqt-','') where group_id=" . $idGroup . "";
 $query = mysqli_query($conn, $stringSQL);

?>