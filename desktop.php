<?php $title = "Desktop"; ?>
<html>
    <?php
        include("head.php");
    ?>
    <body>
    <?php
        if(isset($_SESSION["login"])){
            $files = $db->query("select * from files where user_id={$_SESSION['userid']}");
    ?>
        <form action="index.php" ondrop="drop(event)" ondragover="allow_drop(event)" method="post">
            <canvas id="application"></canvas>
        </form>
    <?php
        include("js/appscript.php");
        } else {
    ?>
    <div class="container">
        <p>For using desktop please <a href="login.php">login</a></p>
    </div>
    <?php
        }
    ?>
    </body>
</html>