<?php
//to show all > Null all value
define('only_quiz',null);
define('only_survey',1);


function pqt_baseurl(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST']."/pqt-khao-sat";
}

function pqt_permission(){
    $baseurl = pqt_baseurl();
    if(!isset($_SESSION['username']))
    {
        header("Location: ".$baseurl."/index.php");
        exit;
    }
}


function is_admin()
{
    if(isset($_SESSION['username'])) return true;
    return false;
}
function is_survey_panel()
{
    $fulllink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."";
    $pos = strpos($fulllink,'survey/admin.php');
    if($pos === false) return false;
    return true;
}

function is_quiz_panel()
{
    $fulllink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."";
    $pos = strpos($fulllink,'quiz/admin.php');
    if($pos === false) return false;
    return true;
}


// Delete question
// function delete_question($idPost,$idGroup)
// {
//     $stringSQL = "delete from survey_questions where question_id=".$idPost."";
//     $query = mysqli_query($conn, $stringSQL);
   
//     $stringSQL = "update survey_groups set group_question = REPLACE(group_question,'" . $idPost . "-pqt-','') where group_id=" . $idGroup . "";
//     $query = mysqli_query($conn, $stringSQL);
// }
?>