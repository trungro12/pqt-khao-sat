
<?php 
include '../db/connect.php';
 // delete  question
$idPost = $_POST['id'];
$idGroup = $_POST['id_group'];
 $stringSQL = "delete from survey_questions where question_id=".$idPost."";
 $query = mysqli_query($conn, $stringSQL);

 $stringSQL = "update survey_groups set group_question = REPLACE(group_question,'" . $idPost . "-pqt-','') where group_id=" . $idGroup . "";
 $query = mysqli_query($conn, $stringSQL);

?>