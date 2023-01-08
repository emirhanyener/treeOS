<?php
    include("db.php");
    $sql_delete = $db->query("update users set background_image = '' where background_image='" . $_POST["filename"] . "'");
?>