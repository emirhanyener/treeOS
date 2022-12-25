<?php
    include("db.php");
    session_start(); 

    $query = $db->query("INSERT INTO files (file_name,position_x,position_y,user_id,foldername,is_folder) VALUES ('".$_POST["foldername"]."',".$_POST["position_x"].",".$_POST["position_y"].",'".$_SESSION["userid"]."','".$_POST["openedfoldername"]."',1)", PDO::FETCH_ASSOC);
    header('Location: desktop.php');
?>