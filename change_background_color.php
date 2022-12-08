<?php
    include("db.php");
    ob_start();
    session_start();
    $sql = $db->query("update users set background_color='".$_POST["color"]."' where id='".$_SESSION["userid"]."'");
    header('Location: desktop.php');
?>