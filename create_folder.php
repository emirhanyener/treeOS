<?php
    include("db.php");
    session_start(); 

    $query = $db->query("INSERT INTO folders (folder_name,position_x,position_y,user_id) VALUES ('".$_POST["foldername"]."',".$_POST["position_x"].",".$_POST["position_y"].",'".$_SESSION["userid"]."')", PDO::FETCH_ASSOC);
?>