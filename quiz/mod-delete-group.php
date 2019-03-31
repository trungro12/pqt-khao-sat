
<?php 
include '../db/connect.php';

$idGroup = $_POST['id'];
$quiz_id = $_POST['quiz_id'];

 // delete  question
$stringSQL = "select * from quiz_groups where group_id=" . $idGroup . "";
$query = mysqli_query($conn, $stringSQL);
$data = mysqli_fetch_array($query);

if($data)
{
    $array_result = explode("-pqt-",$data['group_result']);
    foreach($array_result as $id)
    {
        if($id != "")
        {
            $stringSQL = "delete from quiz_result where result_id=".$id."";
            $query = mysqli_query($conn, $stringSQL);
        }
    }
}



 $stringSQL = "delete from quiz_groups where group_id=".$idGroup."";
 $query = mysqli_query($conn, $stringSQL);

 $stringSQL = "update quiz set quiz_group = REPLACE(quiz_group,'" . $idGroup . "-pqt-','') where quiz_id=" . $quiz_id . "";
 $query = mysqli_query($conn, $stringSQL);

?>