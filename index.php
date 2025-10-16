<?php
include 'common/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all tournaments
$stmt = $pdo->query("SELECT * FROM tournaments ORDER BY start_date ASC");
$tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Upcoming Tournaments</h2>
    <div class="space-y-4">
        <?php foreach ($tournaments as $tournament): ?>
        <div class="bg-gray-800 rounded-lg p-4">
            <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($tournament['name']); ?></h3>
            <p class="text-gray-400"><?php echo htmlspecialchars($tournament['game_name']); ?></p>
            <div class="flex justify-between items-center mt-4">
                <div>
                    <p>Entry: $<?php echo htmlspecialchars($tournament['entry_fee']); ?></p>
                    <p>Prize: <?php echo htmlspecialchars($tournament['prize_pool']); ?></p>
                </div>
                <form action="my_tournaments.php" method="POST">
                    <input type="hidden" name="tournament_id" value="<?php echo $tournament['id']; ?>">
                    <button type="submit" name="join_tournament" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Join
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'common/bottom.php'; ?>