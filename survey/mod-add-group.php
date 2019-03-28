
<?php 
include '../db/connect.php';
 // add -> insert group
$idsurvey = $_POST['idsurvey'];

$stringSQL = "insert INTO survey_groups(group_title,date,group_question,vote) values('',now(),'',1)";
$query = mysqli_query($conn, $stringSQL);
$id_group = mysqli_insert_id($conn);

$stringSQL = "insert INTO survey_questions(question_title,date) values('',now())";
$query = mysqli_query($conn, $stringSQL);
$id_question = mysqli_insert_id($conn);

$stringSQL = "update survey_groups set group_question = CONCAT(group_question, '" . $id_question . "','-pqt-') where group_id = " . $id_group . "";
$query = mysqli_query($conn, $stringSQL);

$stringSQL = "update survey set survey_group = CONCAT(survey_group, '" . $id_group . "','-pqt-') where survey_id = " . $idsurvey . "";
$query = mysqli_query($conn, $stringSQL);

$arr[] = array("id_group" => $id_group,"id_question" => $id_question);
return json_encode($arr);
?>