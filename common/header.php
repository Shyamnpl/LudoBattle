<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en" class="bg-gray-900 text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adept Play</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
    </style>
</head>
<body class="bg-gray-900">
    <header class="bg-gray-800 p-4 flex justify-between items-center fixed top-0 w-full z-10">
        <h1 class="text-xl font-bold">Adept Play</h1>
        <?php if (isset($_SESSION['user_id'])): 
            $stmt = $pdo->prepare("SELECT wallet_balance FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();
        ?>
        <div class="flex items-center space-x-2">
            <i class="fas fa-wallet"></i>
            <span>$<?php echo htmlspecialchars($user['wallet_balance'] ?? '0.00'); ?></span>
        </div>
        <?php endif; ?>
    </header>
    <main class="pt-20 pb-20">