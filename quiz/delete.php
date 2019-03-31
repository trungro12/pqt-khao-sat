<?php include '../db/connect.php';
// if(!is_admin()) exit;
$quiz_id = $_POST['id'];

$stringSQL = "select * from quiz where quiz_id=" . $quiz_id . "";
$query = mysqli_query($conn, $stringSQL);
$data = mysqli_fetch_array($query);
if ($data) {
        $array_groups = explode("-pqt-", $data['quiz_group']);
        foreach ($array_groups as $id) {
                if ($id != "") {

                        // delete  result
                        $stringSQL = "select * from quiz_groups where group_id=" . $id . "";
                        $query = mysqli_query($conn, $stringSQL);
                        $data_ques = mysqli_fetch_array($query);

                        if ($data_ques) {
                                $array_results = explode("-pqt-", $data_ques['group_result']);
                                foreach ($array_results as $id_rs) {
                                        if ($id_rs != "") {
                                                $stringSQL = "delete from quiz_result where result_id=" . $id_rs . "";
                                                $query = mysqli_query($conn, $stringSQL);
                                            }
                                    }
                            }

                        $stringSQL = "delete from quiz_groups where group_id=" . $id . "";
                        $query = mysqli_query($conn, $stringSQL);
                    }
            }
    }

$stringSQL = "delete from quiz where quiz_id=" . $quiz_id . "";
$query = mysqli_query($conn, $stringSQL);

 ?>