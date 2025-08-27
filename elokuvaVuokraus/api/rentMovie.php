<?php 
session_start();
require_once __DIR__ ."/../src/config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to rent a movie']);
    exit;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || 
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'CSRF token mismatch']);
    exit;
}

$movie = trim($_POST['movie'] ?? '');
if ($movie === '' || !ctype_digit($movie) || (int)$movie <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid movie selection']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO vuokraus (JasenID, ElokuvaID,VuokrausPVM,PalautusPVM) VALUES (?, ?,NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))');
    $stmt->execute([$_SESSION['user_id'], (int)$movie]);

    echo json_encode(['success' => true, 'message' => 'Rental successful']);

} catch (PDOException $e) {
    if ($e->getCode() == 23000) { 
        echo json_encode(['success' => false, 'message' => 'Movie already rented']);
    } else {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
}
