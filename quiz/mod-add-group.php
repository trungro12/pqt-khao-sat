
<?php 

include '../db/connect.php';
 // add -> insert group
$quiz_id = $_POST['quiz_id'];

$stringSQL = "insert INTO quiz_groups(group_title,date,group_result,true_result) values('',now(),'',0)";
$query = mysqli_query($conn, $stringSQL);
$id_group = mysqli_insert_id($conn);

$stringSQL = "insert INTO quiz_result(result_title,date) values('',now())";
$query = mysqli_query($conn, $stringSQL);
$id_result = mysqli_insert_id($conn);

$stringSQL = "update quiz_groups set true_result=".$id_result.", group_result = CONCAT(group_result, '" . $id_result . "','-pqt-') where group_id = " . $id_group . "";
$query = mysqli_query($conn, $stringSQL);

$stringSQL = "update quiz set quiz_group = CONCAT(quiz_group, '" . $id_group . "','-pqt-') where quiz_id = " . $quiz_id . "";
$query = mysqli_query($conn, $stringSQL);

$arr = array("id_groups" => intval($id_group),"id_results" => intval($id_result));
echo json_encode($arr);
?>