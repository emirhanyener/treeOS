<div class="menu">
    <div class="menu-item" style="position:relative;">
        <a href="index.php" style="height:100px;" id="logo">
            <img src="images/logo.png" height="100" class="" alt="logo">
        </a>
    </div>
    <div class="menu-item">
        <a class="menu-item-right" style="color:white;background-color: #13a313;border-radius: 45px;" href="desktop.php">Desktop</a>
        <?php
            if(isset($_SESSION["login"])){
                echo '<a class="menu-item-right" href="user.php">'.$_SESSION["username"].'</a>';
            } else {
        ?>
            <a class="menu-item-right" href="login.php">Login</a>
            <a class="menu-item-right" href="register.php">Register</a>
        <?php
            }
        ?>
        <a class="menu-item-right" href="index.php">Home</a>
    </div>
</div>