
<?php 
include '../db/connect.php';

$idGroup = $_POST['id'];
$id_survey = $_POST['id_survey'];

 // delete  question
$stringSQL = "select * from survey_questions where question_id=" . $idGroup . "";
$query = mysqli_query($conn, $stringSQL);
$data = mysqli_fetch_array($query);

if($data)
{
    $array_questions = explode("-pqt-",$data['group_question']);
    foreach($array_questions as $id)
    {
        if($id != "")
        {
            $stringSQL = "delete from survey_questions where question_id=".$id."";
            $query = mysqli_query($conn, $stringSQL);
        }
    }
}



 $stringSQL = "delete from survey_groups where group_id=".$idPost."";
 $query = mysqli_query($conn, $stringSQL);

 $stringSQL = "update survey set survey_group = REPLACE(survey_group,'" . $idGroup . "-pqt-','') where survey_id=" . $id_survey . "";
 $query = mysqli_query($conn, $stringSQL);

?>