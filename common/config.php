<?php
session_start();

$db_host = '127.0.0.1';
$db_name = 'adept_play';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Global JavaScript for disabling context menu, text selection, and zoom
$disable_interactions_js = <<<JS
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.addEventListener('selectstart', event => event.preventDefault());
    document.addEventListener('keydown', function (event) {
        if ((event.ctrlKey || event.metaKey) && (event.key === '+' || event.key === '-' || event.key === '0')) {
            event.preventDefault();
        }
    });
    document.addEventListener('wheel', function (event) {
        if (event.ctrlKey || event.metaKey) {
            event.preventDefault();
        }
    }, { passive: false });
</script>
JS;
?>