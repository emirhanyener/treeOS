<?php
    include("db.php");
    ob_start();
    session_start();
    $sql = $db->query("update users set desktop_name='".$_POST["desktopname"]."' where id='".$_SESSION["userid"]."'");
    header('Location: desktop.php');
?>