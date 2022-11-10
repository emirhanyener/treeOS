<?php $title = "Login"; ?>
<html>
<?php include("head.php"); ?>
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $db->query("SELECT * FROM users where username='".$_POST["username"]."' and password = '".$_POST["pass"]."'")->fetch(PDO::FETCH_ASSOC);
    if ( $query ){
        $_SESSION["login"] = 1;
        $_SESSION["userid"] = $query["id"];
        $_SESSION["username"] = $query["username"];
        $_SESSION["usermail"] = $query["mail"];
        $_SESSION["userisadmin"] = $query["is_admin"];
        header("Location: index.php");
    }
    header("Location: login.php");
}
?>
<body>
    <?php include("menu.php"); ?>

    <?php
        if($_SESSION["login"] == 1){
    ?>
        already logged<br>
        <?php echo $_SESSION["username"]; ?> <br>
        <?php echo $_SESSION["usermail"]; ?> <br>
        <?php 
            if($_SESSION["userisadmin"] == 1){
                echo "user is admin";
            } 
        ?> <br>
        <a href = "logout.php">Logout</a>
    <?php
    } else {
    ?>
        <form action="login.php"  method="POST">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username"><br>
            <label for="pass" class="form-label">Password</label>
            <input type="text" class="form-control" id="pass" name="pass"><br>
            <input type="submit" class="form-control" value="Login">
        </form>
    <?php
    }
    ?>
    <?php include("footer.php"); ?>
</body>
</html>