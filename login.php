<?php $title = "Login"; 
session_start();
?>
<html>
    <?php 
        include("head.php");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $db->query("SELECT * FROM users where username='".$_POST["username"]."' and password = '".$_POST["pass"]."'")->fetch(PDO::FETCH_ASSOC);
            if ($query){
                $_SESSION["login"] = 1;
                $_SESSION["userid"] = $query["id"];
                $_SESSION["username"] = $query["username"];
                $_SESSION["usermail"] = $query["mail"];
                $_SESSION["userisadmin"] = $query["is_admin"];
                header("Location: index.php");
            }
            else{
                header("Location: login.php");
            }
        }
    ?>
        <div class="container">
            <?php 
                include("menu.php");
                if($_SESSION["login"] == 1){
            ?>
                <pageheader>Login</pageheader>
                Already logged<br>
                <br>
                <a href = "logout.php" class="c-r">Logout</a>
            <?php
                } else {
            ?>
                <pageheader>Login</pageheader>
                <form action="login.php" class="center-form" method="POST">
                    <table class="form-table">
                        <tr><td><label for="username" class="form-label">Username: </label></td>
                        <td><input type="text" class="input-text" id="username" name="username"></td></tr>
                        <tr><td><label for="pass" class="form-label">Password: </label></td>
                        <td><input type="text" class="input-text" style="-webkit-text-security: disc;" id="pass" name="pass"></td></tr>
                        <tr><td colspan="2"><input type="submit" class="input-button bg-c-b c-w" value="Login"></td><tr>
                    </table>
                </form>
            <?php
                }
            ?>
            <?php
                include("footer.php");
            ?>
        </div>
</html>