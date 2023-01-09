<?php
error_reporting(E_ERROR | E_PARSE);

session_start();
    include("db.php");
    if(file_exists("uploads/".$_POST["filename"]))
        unlink("uploads/".$_POST["filename"]);
    if (explode(".", $_POST["filename"])[1] == "png" || explode(".", $_POST["filename"])[1] == "jpg") {
        $sql_select = $db->query("select * from users where background_image ='" . $_POST["filename"] . "'");
        if ($sql_select->rowCount() == 1) {
            $sql_delete = $db->query("update users set background_image = '' where background_image='" . $_POST["filename"] . "'");
        }
    }
    if ($db->query("select * from files where foldername='" . $_POST["filename"] . "' and user_id = '".$_SESSION["userid"]."'")->rowCount() == 0) {
        $sql_delete = $db->query("delete from files where file_name='" . $_POST["filename"] . "' and user_id = '".$_SESSION["userid"]."'");
        echo 1;
    }
?>