<?php 
    include("db.php"); 
    if ($db->query("select * from users where mail_verification = '" . $_GET["hash"] . "'", PDO::FETCH_ASSOC)->rowCount() != 0) {
        $query = $db->query("update users set mail_active = 1 where username = '" . $db->query("select * from users where mail_verification = '" . $_GET["hash"] . "'", PDO::FETCH_ASSOC)->fetch()["username"] . "'", PDO::FETCH_ASSOC);
        header("Location: index.php");
    } else {
        header("Location: register.php");
    }
?>