<?php
    error_reporting(E_ERROR | E_PARSE); 
    session_start(); 
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777);
    }
    $filename = $_SESSION["userid"].'_'.$_FILES['file']['name'];            

    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$filename);
      
    echo 'uploads/'.$filename;
?>