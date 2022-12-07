<?php
    include("db.php");
    ob_start();
    session_start();
    $newfilename = $_SESSION["userid"].'_'.time().'_'.$_POST["tofilename"];
    if(file_exists("uploads/".$_POST["filename"]))
        rename("uploads/".$_POST["filename"], "uploads/".$newfilename);
    $sql = $db->query("update files set file_name='".$newfilename."' where file_name='".$_POST["filename"]."'");
    header('Location: desktop.php');
?>