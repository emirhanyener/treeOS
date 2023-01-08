<?php
    include("db.php");
    ob_start();
    session_start();
    $sql = $db->query("update users set background_image='".$_POST["filename"]."' where id='".$_SESSION["userid"]."'");
    header('Location: desktop.php');
?>