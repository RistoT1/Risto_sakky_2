<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ .'/../src/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("
        SELECT e.ElokuvaID, e.Nimi, v.PalautusPVM
        FROM vuokraus v
        JOIN elokuva e ON v.ElokuvaID = e.ElokuvaID
        WHERE v.JasenID = ?
        ORDER BY v.VuokrausPVM DESC
    ");
    $stmt->execute([$user_id]);

    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $movies]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
