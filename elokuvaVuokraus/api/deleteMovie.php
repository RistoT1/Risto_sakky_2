<?php
session_start();
require_once __DIR__ . '/../src/config.php';
header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}


$headers = getallheaders();
if (!isset($headers['X-CSRF-Token']) || $headers['X-CSRF-Token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}


$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}


if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid movie ID']);
    exit;
}

$movieId = (int) $_GET['movieId'];

try {
    $stmt = $pdo->prepare('DELETE FROM vuokraus WHERE ElokuvaID = ? AND JasenID = ?');
    $stmt->execute([$movieId, $userId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Movie deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Movie not found or could not be deleted']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}
?>
