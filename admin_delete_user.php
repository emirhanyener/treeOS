<?php
    include("db.php");
    $sql_files = $db->query("delete from files where user_id='".$_GET["userid"]."'");
    $sql_users = $db->query("delete from users where id='".$_GET["userid"]."'");

    header("Location: admin_users.php");
?>