
<?php 
include '../db/connect.php';
 // delete  question, not completed
$idGroup = $_POST['id'];
$id_survey = $_POST['id_survey'];
 $stringSQL = "delete from survey_groups where group_id=".$idPost."";
 $query = mysqli_query($conn, $stringSQL);

 $stringSQL = "update survey set survey_group = REPLACE(survey_group,'" . $idGroup . "-pqt-','') where survey_id=" . $id_survey . "";
 $query = mysqli_query($conn, $stringSQL);

?>