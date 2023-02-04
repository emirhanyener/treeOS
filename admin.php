<?php $title = "Admin"; 
session_start();
?>
<html>
    <?php 
        include("head.php");
        ?>
        <div class="container">
            <?php 
    if (isset($_SESSION["userisadmin"])) {
        if ($_SESSION["userisadmin"] == 1) {
            include("admin_menu.php");
            ?>
    <?php
        }
    }
        else {
            echo "please <a href='login.php'>login</a>";
        }
    ?>
    </div>
</html>