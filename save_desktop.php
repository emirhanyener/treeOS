<?php
    include("db.php");
    error_reporting(E_ERROR | E_PARSE); 
    session_start(); 

    $sql = $db->prepare("UPDATE files SET position_x=?, position_y=? where user_id=? and file_name=?");
    $sql->execute([$_POST["position_x"], $_POST["position_y"], $_SESSION["userid"], $_POST["filename"]]);
?>