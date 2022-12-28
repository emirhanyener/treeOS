<?php
    $title = "Register";
?>
<html>
    <?php
        include("head.php");
    ?>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($db->query("select * from users where username = '" . str_replace("\"","",str_replace("'","",$_POST["username"])) . "' or mail = '" . str_replace("\"","",str_replace("'","",$_POST["mail"])) . "'", PDO::FETCH_ASSOC)->rowCount() == 0) {
                $query = $db->query("INSERT INTO users (username,password,mail,mail_active,is_admin,desktop_name,background_color,background_image,mail_verification) VALUES ('" . str_replace("\"","",str_replace("'","",$_POST["username"])) . "','" . str_replace("\"","",str_replace("'","",$_POST["pass"])) . "','" . str_replace("\"","",str_replace("'","",$_POST["mail"])) . "',0,0,'','','','".hash("md5",$_POST["username"])."')", PDO::FETCH_ASSOC);
                mail($_POST["mail"], "treeOS mail verification", "Click this link for mail verification:http://www.emirhanyener.space/treeOS/mail_verification.php?hash=".hash("md5",$_POST["username"]));
                header("Location: index.php");
            } else {
                header("Location: register.php");
            }
        }
    ?>
        <div class="container">
            <?php
                include("menu.php");
            ?>
            <pageheader>Register</pageheader>
            <form action="register.php" class="center-form" method="POST">
                <table class="form-table">
                    <tr>
                        <td><label for="username" class="form-label">Username</label></td>
                        <td><input type="text" class="input-text" id="username" name="username"></td>
                    </tr>
                    <tr>
                        <td><label for="pass" class="form-label">Password</label></td>
                        <td><input type="text" class="input-text" style="-webkit-text-security: disc;" id="pass" name="pass"></td>
                    </tr>
                    <tr>
                        <td><label for="mail" class="form-label">Email address</label></td>
                        <td><input type="text" class="input-text" id="mail" name="mail"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" class="input-button bg-c-b c-w" value="Register"></td>
                    </tr>
                </table>
            </form>
            <?php
                include("footer.php");
            ?>
        </div>
</html>