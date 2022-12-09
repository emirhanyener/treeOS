<?php $title = "Home"; 
session_start();
?>
<html>
    <?php include("head.php"); ?>
        <div class="container">
            <?php include("menu.php"); ?>
                <pageheader>Welcome</pageheader>
                <p>treeOS is a virtual file management system on web.</p>
                <?php if(!isset($_SESSION["login"])) { ?>
                    <p><a href="login.php" style="color:blue;">Login</a> and upload files</p>
                <?php } ?>
                <div class="slider">
                    <div class="slider-img">
                        <img src="images/start_menu.PNG">
                        <font>Start Menu</font>
                    </div>
                    <div class="slider-img">
                        <img src="images/desktop_folder.PNG">
                        <font>Folder</font>
                    </div>
                    <div class="slider-img">
                        <img src="images/file_modes.PNG">
                        <font>File Context Menu</font>
                    </div>
                    <div class="slider-img">
                        <img src="images/rename_file.PNG">
                        <font>Rename File</font>
                    </div>
                </div>
            <?php include("footer.php"); ?>
        </div>


        
<script>
    var slider_index = 0;
    function slider() {
        var images = document.getElementsByClassName("slider-img");
        for (var i = 0; i < images.length; i++) {
            images[i].style.display = "none";  
        }
        slider_index++;
        if (slider_index > images.length) {
            slider_index = 1
        }
        
        images[slider_index - 1].style.display = "block";
    }
    setInterval(() => { slider(); }, 2500);
</script>
</html>