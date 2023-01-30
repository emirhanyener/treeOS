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
                <form action="change_password.php" method="POST">
                <table>
                    <tr><td>Username</td><td><input type="text" value="<?php echo $_SESSION['username']; ?>" name="username" readonly></td></tr>
                    <tr><td>Mail</td><td><input type="text" value="<?php echo $_SESSION['usermail']; ?>" name="mail" readonly></td></tr>
                    <tr><td>Password</td><td><input type="text" style="-webkit-text-security: disc;" name="password"></td></tr>
                    <tr><td colspan="2"><input type="submit" value="Change Password"></td></tr>
                </table>
                </form>
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