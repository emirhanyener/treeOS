<?php
    include("db.php");
    if(file_exists("uploads/".$_GET["filename"]))
        unlink("uploads/".$_GET["filename"]);
    $sql = $db->query("delete from files where file_name='".$_GET["filename"]."'");

    header("Location: desktop_responsive.php");
?>