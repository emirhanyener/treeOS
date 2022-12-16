<?php $title = "Desktop Responsive"; 
session_start();
?>
<html>
    <?php include("head.php"); ?>
        <div class="container">
            <?php include("menu.php"); ?>    
            <?php
                if(isset($_SESSION["login"])){
                    $files = $db->query("select * from files where user_id={$_SESSION['userid']}");
                    $user = $db->query("select * from users where id={$_SESSION['userid']}")->fetch(PDO::FETCH_ASSOC);
            ?>
                <div id="body">
                    <h2><?php echo $user["username"]; ?>'s files</h2>
                    <table class="files-table">
                    <tr>
                        <th>File Name</th>
                        <th>Download</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                        foreach($files as $item){
                            if($item["is_folder"] == 1)
                                continue;
                    ?>
                    <tr>
                        <td><?php echo explode("_", $item['file_name'])[2]; ?></td>
                        <td><a href="<?php echo 'uploads/'.$item['file_name']; ?>" download>Download</a></td>
                        <td><a href="form_delete_file.php?filename=<?php echo $item['file_name']; ?>">Delete</a></td>
                    </tr>
                    <?php
                        }
                    ?>
                    
                    </table>

                    <h2>Upload File</h2>
                    <table>
                        <form method="POST" action="form_file_upload.php" enctype="multipart/form-data">
                            <tr><td>File: </td><td><input type="file" name="file" id="file"></td></tr>
                            <tr><td colspan = "2"><input style="width:100%;padding:10px;color:green;background-color:white;border: 2px solid green;" type="submit" name="position_y" value ="Upload"></td><td>
                        </form>
                    </table>
                <?php
                    } else {
                ?>
                <div class="container">
                    <p>For using desktop please <a href="login.php">login</a></p>
                </div>
                <?php
                    }
                ?>
            <?php include("footer.php"); ?>
        </div>
</html>