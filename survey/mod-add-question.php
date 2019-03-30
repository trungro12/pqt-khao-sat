
<?php 
include '../db/connect.php';
 // update -> insert question
$idGroup = $_POST['id'];
 $stringSQL = "insert into survey_questions(question_title,date) values('',now())";
 $query = mysqli_query($conn, $stringSQL);
 $id_question = mysqli_insert_id($conn);

 $stringSQL = "update survey_groups set group_question = CONCAT(group_question,'" . $id_question . "','-pqt-') where group_id=" . $idGroup . "";
 $query = mysqli_query($conn, $stringSQL);
echo $id_question;

?>