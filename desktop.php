<?php $title = "Desktop"; ?>
<html>
    <?php
        include("head.php");
    ?>
    <?php
        if(isset($_SESSION["login"])){
    ?>
    <body>
        <canvas id="application"></canvas>
    </body>
    <?php
        } else {
    ?>
    <div class="container">
        <p>For using desktop please <a href="login.php">login</a></p>
    </div>
    <?php
        }
        include("js/appscript.php");
    ?>
</html>