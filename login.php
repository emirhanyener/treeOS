<?php $title = "Login"; 
session_start();
?>
<html>
    <?php 
        include("head.php");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $db->query("SELECT * FROM users where username='".str_replace("\"","",str_replace("'","",$_POST["username"]))."' and password = '".str_replace("\"","",str_replace("'","",$_POST["pass"]))."'")->fetch(PDO::FETCH_ASSOC);
            if ($query["mail_active"] == 1){
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
                <?php
                    if($_GET["d"] == "verification"){
                        echo "<br><font style='color:white;border-radius:10px;padding:15px;background-color:#00BB00DD;'>user verification mail has been sended to <b>".$_GET["mail"]."</b></font><br>";
                    }
                ?>
                <form action="login.php" class="center-form" method="POST">
                    <table class="form-table">
                        <tr><td><label for="username" class="form-label">Username: </label></td>
                        <td><input type="text" class="input-text" id="username" name="username" required></td></tr>
                        <tr><td><label for="pass" class="form-label">Password: </label></td>
                        <td><input type="text" class="input-text" style="-webkit-text-security: disc;" id="pass" name="pass" required></td></tr>
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