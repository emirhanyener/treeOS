<?php
    include("db.php");
    ob_start();
    session_start();
    if($_POST["isfolder"] == 0) {
        $newfilename = $_SESSION["userid"].'_'.time().'_'.$_POST["tofilename"];
        if(file_exists("uploads/".$_POST["filename"]))
            rename("uploads/".$_POST["filename"], "uploads/".$newfilename);
    } else {
        $newfilename = $_POST["tofilename"];
    }
    $sql = $db->query("update files set file_name='".$newfilename."' where file_name='".$_POST["filename"]."'");
    header('Location: desktop.php');
?>