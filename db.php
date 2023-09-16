<?php
    include("config.php"); 
    try {
        $db = new PDO("mysql:host=localhost;dbname=".$database_name, $username, $password);
    } catch (PDOException $e) {
        print $e->getMessage();
    }
?>