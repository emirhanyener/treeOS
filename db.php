<?php
    try {
        $db = new PDO("mysql:host=localhost;dbname=treeos", "root", "root");
    } catch (PDOException $e) {
        print $e->getMessage();
    }
?>