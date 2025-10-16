<?php
include 'common/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
// Fetch user's balance from header's query
$stmt = $pdo->prepare("SELECT wallet_balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$balance = $stmt->fetchColumn();
?>

<div class="p-4 text-center">
    <h2 class="text-2xl font-bold mb-4">My Wallet</h2>
    <div class="bg-gray-800 p-8 rounded-lg">
        <p class="text-gray-400">Current Balance</p>
        <p class="text-5xl font-bold mt-2">$<?php echo htmlspecialchars($balance); ?></p>
    </div>
    <p class="mt-4 text-gray-500">Wallet functionality coming soon.</p>
</div>

<?php include 'common/bottom.php'; ?>