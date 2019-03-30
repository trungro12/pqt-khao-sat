<?php include '../db/connect.php';
// if(!is_admin()) exit;
$survey_id = $_POST['id'];

$stringSQL = "select * from survey where survey_id=" . $survey_id . "";
$query = mysqli_query($conn, $stringSQL);
$data = mysqli_fetch_array($query);
if ($data) {
        $array_groups = explode("-pqt-", $data['survey_group']);
        foreach ($array_groups as $id) {
                if ($id != "") {

                        // delete  question
                        $stringSQL = "select * from survey_groups where group_id=" . $id . "";
                        $query = mysqli_query($conn, $stringSQL);
                        $data_ques = mysqli_fetch_array($query);

                        if ($data_ques) {
                                $array_questions = explode("-pqt-", $data_ques['group_question']);
                                foreach ($array_questions as $id_ques) {
                                        if ($id_ques != "") {
                                                $stringSQL = "delete from survey_questions where question_id=" . $id_ques . "";
                                                $query = mysqli_query($conn, $stringSQL);
                                            }
                                    }
                            }

                        $stringSQL = "delete from survey_groups where group_id=" . $id . "";
                        $query = mysqli_query($conn, $stringSQL);
                    }
            }
    }

$stringSQL = "delete from survey where survey_id=" . $survey_id . "";
$query = mysqli_query($conn, $stringSQL);

 ?>