<?php
    $title = "Register";
?>
<html>
    <?php
        include("head.php");
    ?>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $db->query("INSERT INTO users (username,password,mail,is_admin) VALUES ('".$_POST["username"]."','".$_POST["pass"]."','".$_POST["mail"]."',0)", PDO::FETCH_ASSOC);
            header("Location: index.php");
        }
    ?>
    <body>
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
    </body>
</html>