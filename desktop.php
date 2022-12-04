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
        <canvas ondrop="drop(event)" ondragover="allow_drop(event)" ondblclick="open_file()" id="application"></canvas>
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