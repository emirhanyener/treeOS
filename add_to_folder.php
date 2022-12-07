<?php
    include("db.php");
    ob_start();
    session_start();
    $sql = $db->query("update files set foldername='".$_POST["foldername"]."' where file_name='".$_POST["filename"]."'");
?>