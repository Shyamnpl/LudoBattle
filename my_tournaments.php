<?php
include 'common/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle joining a tournament
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['join_tournament'])) {
    $tournament_id = $_POST['tournament_id'];

    // Check if already joined
    $stmt = $pdo->prepare("SELECT * FROM participants WHERE user_id = ? AND tournament_id = ?");
    $stmt->execute([$user_id, $tournament_id]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO participants (user_id, tournament_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $tournament_id]);
    }
}

// Fetch user's joined tournaments
$stmt = $pdo->prepare("
    SELECT t.* FROM tournaments t
    JOIN participants p ON t.id = p.tournament_id
    WHERE p.user_id = ?
");
$stmt->execute([$user_id]);
$my_tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">My Tournaments</h2>
    <div class="space-y-4">
        <?php if (empty($my_tournaments)): ?>
            <p class="text-gray-400">You haven't joined any tournaments yet.</p>
        <?php else: ?>
            <?php foreach ($my_tournaments as $tournament): ?>
            <div class="bg-gray-800 rounded-lg p-4">
                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($tournament['name']); ?></h3>
                <p class="text-gray-400"><?php echo htmlspecialchars($tournament['game_name']); ?></p>
                <p class="text-sm mt-2">Status: <span class="font-bold text-yellow-400"><?php echo ucfirst($tournament['status']); ?></span></p>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'common/bottom.php'; ?>