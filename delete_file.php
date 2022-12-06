<?php
    include("db.php");
    if(file_exists("uploads/".$_POST["filename"]))
        unlink("uploads/".$_POST["filename"]);
    $sql = $db->query("delete from files where file_name='".$_POST["filename"]."'");
?>