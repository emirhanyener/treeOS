<?php $title = "Home"; 
session_start();
?>
<html>
    <?php include("head.php"); ?>
        <div class="container">
            <?php include("menu.php"); ?>
                <pageheader>Welcome</pageheader>
                <p>treeOS is a virtual file management system on web.</p>
                <?php if(!isset($_SESSION["login"])) { ?>
                    <p><a href="login.php" style="color:blue;">Login</a> and upload files</p>
                <?php } ?>
            <?php include("footer.php"); ?>
        </div>
</html>