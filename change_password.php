<?php
    include("db.php");
    ob_start();
    session_start();
    $sql = $db->query("update users set password='".$_POST["password"]."' where username='".$_SESSION["username"]."'");
    header('Location: user.php');
?>