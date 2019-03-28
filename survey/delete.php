<?php include '../db/connect.php';

$survey_id = $_POST['id'];

$stringSQL = "delete from survey where survey_id=" . $survey_id . "";
$query = mysqli_query($conn, $stringSQL);

?>
