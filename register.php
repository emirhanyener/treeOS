<?php $title = "Register"; ?>
<html>
<?php include("head.php"); ?>
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $db->query("INSERT INTO users (username,password,mail,is_admin) VALUES ('".$_POST["username"]."','".$_POST["pass"]."','".$_POST["mail"]."',0)", PDO::FETCH_ASSOC);
    header("Location: index.php");
}
?>
<body>
    <?php include("menu.php"); ?>

    <form action="register.php"  method="POST">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username"><br>
        <label for="pass" class="form-label">Password</label>
        <input type="text" class="form-control" id="pass" name="pass"><br>
        <label for="mail" class="form-label">Email address</label>
        <input type="text" class="form-control" id="mail" name="mail"><br>
        <input type="submit" class="form-control" value="Register">
    </form>

    <?php include("footer.php"); ?>
</body>
</html>