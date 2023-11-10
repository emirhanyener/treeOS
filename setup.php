<?php
    include("config.php"); 
    try {
        $db = new PDO("mysql:host=localhost;dbname=".$database_name, $username, $password);
        $db->query("CREATE TABLE `files` (
            `id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `file_name` varchar(50) NOT NULL,
            `position_x` int(11) NOT NULL,
            `position_y` int(11) NOT NULL,
            `foldername` varchar(50) NOT NULL,
            `is_folder` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        $db->query("ALTER TABLE `files` ADD PRIMARY KEY (`id`);");
        $db->query("ALTER TABLE `files` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");

        $db->query("CREATE TABLE `users` (
            `id` int(11) NOT NULL,
            `username` varchar(100) NOT NULL,
            `password` varchar(100) NOT NULL,
            `mail` varchar(100) NOT NULL,
            `is_admin` int(11) NOT NULL,
            `mail_active` int(11) NOT NULL,
            `mail_verification` varchar(100) NOT NULL,
            `desktop_name` varchar(50) NOT NULL,
            `background_color` varchar(20) NOT NULL,
            `background_image` varchar(100) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        $db->query("ALTER TABLE `users` ADD PRIMARY KEY (`id`);");
        $db->query("ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        echo "Database created!";
    } catch (PDOException $e) {
        echo "Database already created!";
    }
?>