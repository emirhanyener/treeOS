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
                header("Location: login.php?d=verification&mail=".$_POST["mail"]);
            } else {
                header("Location: register.php?d=error");
            }
        }
    ?>
        <div class="container">
            <?php
                include("menu.php");
            ?>
            <pageheader>Register</pageheader>
            <?php
                if($_GET["d"] == "error"){
                    echo "<br><font style='color:white;border-radius:10px;padding:15px;background-color:#FF0000DD;'>username or e-mail already exists</font><br>";
                }
            ?>
            <form action="register.php" class="center-form" method="POST">
                <table class="form-table">
                    <tr>
                        <td><label for="username" class="form-label">Username</label></td>
                        <td><input type="text" class="input-text" id="username" name="username" required></td>
                    </tr>
                    <tr>
                        <td><label for="pass" class="form-label">Password</label></td>
                        <td><input type="text" class="input-text" style="-webkit-text-security: disc;" id="pass" name="pass" required></td>
                    </tr>
                    <tr>
                        <td><label for="mail" class="form-label">Email address</label></td>
                        <td><input type="text" class="input-text" id="mail" name="mail" required></td>
                    </tr>
                    <tr>
                        <td><canvas width="110px" height="35px" style="border:2px solid red;" id="verification_canvas"></canvas></td>
                        <td><input type="text" class="input-text" name="verification_text" id="verification_text" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" class="input-button bg-c-b c-w" style="opacity: 0.6;" id="register_button" value="Register" disabled></td>
                    </tr>
                    <script>
                        //random text
                        let chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZ0123456789";
                        let c_chars = "0123456789ABCDEF";
                        let verification_text = "";
                        for (let index = 0; index < 4; index++) {
                            verification_text += chars[Math.floor(Math.random() * chars.length)];
                        }

                        var verification_input = document.getElementById("verification_text");
                        var register_button = document.getElementById("register_button");
                        var canvas = document.getElementById("verification_canvas");
                        var ctx = canvas.getContext("2d");
                        var front_stroke_color = "#";
                        var text_stroke_color = "#";
                        for (let index = 0; index < 3; index++) {
                            front_stroke_color += c_chars[Math.floor(Math.random() * c_chars.length)];
                        }
                        for (let index = 0; index < 3; index++) {
                            text_stroke_color += c_chars[Math.floor(Math.random() * 10)];
                        }
                        ctx.strokeStyle = front_stroke_color;
                        ctx.fillStyle = text_stroke_color;
                        ctx.font = "32px Arial";
                        ctx.fillText(verification_text,5,28);
                        ctx.beginPath();
                        for (let index = 1; index < 7; index++) {
                            ctx.moveTo(0, 5 * index);
                            ctx.lineTo(110, 5 * index);
                        }
                        for (let index = 1; index < 22; index++) {
                            ctx.moveTo(5 * index, 0);
                            ctx.lineTo(5 * index, 35);
                        }
                        ctx.stroke();

                        verification_input.addEventListener('change', verificaton_text_changed);

                        function verificaton_text_changed(){
                            if(verification_text == verification_input.value){
                                register_button.disabled = false;
                                register_button.style = "opacity: 1;";
                                canvas.style = "border: 2px solid green;";
                            } else {
                                register_button.disabled = true;
                                register_button.style = "opacity: 0.6;";
                                canvas.style = "border: 2px solid red;";
                            }
                        }
                    </script>
                </table>
            </form>
            <?php
                include("footer.php");
            ?>
        </div>
</html>