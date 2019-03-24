<?php
// Get Url Home
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
    }
}




?>