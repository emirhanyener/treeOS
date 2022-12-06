<?php
    include("db.php");
    error_reporting(E_ERROR | E_PARSE); 
    session_start(); 
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777);
    }
    $filename = $_SESSION["userid"].'_'.time().'_'.$_FILES['file']['name'];

    $query = $db->query("INSERT INTO files (file_name,position_x,position_y,user_id) VALUES ('".$filename."',100,100,'".$_SESSION["userid"]."')", PDO::FETCH_ASSOC);

    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$filename);
      
    echo 'uploads/'.$filename;
?>