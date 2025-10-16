<?php
include 'common/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Profile</h2>
    <div class="bg-gray-800 p-6 rounded-lg">
        <div class="mb-4">
            <label class="block text-gray-400">Username</label>
            <p class="text-lg"><?php echo htmlspecialchars($user['username']); ?></p>
        </div>
        <div class="mb-6">
            <label class="block text-gray-400">Email</label>
            <p class="text-lg"><?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <form action="profile.php" method="POST">
            <button type="submit" name="logout" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Logout
            </button>
        </form>
    </div>
</div>

<?php include 'common/bottom.php'; ?>