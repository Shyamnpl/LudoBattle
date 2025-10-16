<?php
include 'common/config.php';

try {
    $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");
    $pdo->exec("USE `$db_name`");

    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `wallet_balance` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    // Create tournaments table
    $sql = "CREATE TABLE IF NOT EXISTS `tournaments` (
        `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `game_name` VARCHAR(100) NOT NULL,
        `description` TEXT,
        `entry_fee` DECIMAL(10, 2) NOT NULL,
        `prize_pool` VARCHAR(255) NOT NULL,
        `max_players` INT(11) NOT NULL,
        `start_date` DATETIME NOT NULL,
        `end_date` DATETIME NOT NULL,
        `status` ENUM('upcoming', 'ongoing', 'completed') NOT NULL DEFAULT 'upcoming',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    // Create participants table
    $sql = "CREATE TABLE IF NOT EXISTS `participants` (
        `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT(11) UNSIGNED NOT NULL,
        `tournament_id` INT(11) UNSIGNED NOT NULL,
        `joined_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (tournament_id) REFERENCES tournaments(id)
    )";
    $pdo->exec($sql);

    // Create admins table
    $sql = "CREATE TABLE IF NOT EXISTS `admins` (
        `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sql);
    
    // Insert a default admin user
    $admin_user = 'admin';
    $admin_pass = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO `admins` (`username`, `password`) VALUES (?, ?)");
    $stmt->execute([$admin_user, $admin_pass]);

    // Create settings table
    $sql = "CREATE TABLE IF NOT EXISTS `settings` (
        `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `setting_name` VARCHAR(100) NOT NULL UNIQUE,
        `setting_value` VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sql);

    echo "Database and tables created successfully!";

} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>