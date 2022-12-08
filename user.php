<?php $title = "User"; 
session_start();
?>
<html>
    <?php 
        include("head.php");
        ?>
        <div class="container">
            <?php 
                include("menu.php");
                if(isset($_SESSION["login"])){
            ?>
                <pageheader>User</pageheader>
                <?php echo $_SESSION["username"]; ?><br>
                <?php echo $_SESSION["usermail"]; ?><br>
                <br>
                <a href = "logout.php" class="c-r">Logout</a>
            <?php
                } else {
            ?>
                You are not logged in.
            <?php
                }
            ?>
            <?php
                include("footer.php");
            ?>
        </div>
</html>