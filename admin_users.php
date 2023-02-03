<?php $title = "Admin Users"; 
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
    <pageheader>Users</pageheader>
    <table class="files-table">
        <tr>
            <th>Username</th>
            <th>Mail</th>
            <th>Delete</th>
        </tr>
        <?php
            $users = $db->query("select * from users");
            foreach($users as $item){
                if($item["is_admin"] == 1)
                    continue;
        ?>
        <tr>
            <td><?php echo $item['username']; ?></td>
            <td><?php echo $item['mail']; ?></td>
            <td><a href="admin_delete_user.php?userid=<?php echo $item['id']; ?>">Delete</a></td>
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