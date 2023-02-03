<?php $title = "Admin Files"; 
session_start();
?>
<html>
    <?php 
        include("head.php");
        ?>
        <div class="container">
            <?php 
    if (isset($_SESSION["userisadmin"])) {
        if ($_SESSION["userisadmin"] == 1) {
            include("admin_menu.php");
            ?>
    <pageheader>Files</pageheader>
    <table class="files-table">
        <tr>
            <th>Username</th>
            <th>File Name</th>
            <th>Download</th>
            <th>Delete</th>
        </tr>
        <?php
            $files = $db->query("select * from files inner join users on files.user_id = users.id");
            foreach($files as $item){
                if($item["is_folder"] == 1)
                    continue;
        ?>
        <tr>
            <td><?php echo $item['username']; ?></td>
            <td><?php echo explode("_", $item['file_name'])[2]; ?></td>
            <td><a href="<?php echo 'uploads/'.$item['file_name']; ?>" download>Download</a></td>
            <td><a href="admin_delete_file.php?filename=<?php echo $item['file_name']; ?>">Delete</a></td>
        </tr>
        <?php
            }
        ?>
        
    </table>
    <?php
        }
    }
        else {
            echo "please <a href='login.php'>login</a>";
        }
    ?>
    </div>
</html>