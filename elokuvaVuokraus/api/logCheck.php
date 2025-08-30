<?php
session_start();
require_once __DIR__ . "/../src/config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'CSRF token mismatch']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Username or password is invalid']);
    exit;
}

try {

    $stmt = $pdo->prepare('SELECT JasenID, SalasanaHash, is_admin FROM jasen WHERE BINARY Kayttajatunnus = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['SalasanaHash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['JasenID'];
        $_SESSION['user'] = $username;
        $_SESSION['loggedIn'] = true;
        $_SESSION['is_admin'] = (bool) $user['is_admin'];


        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
}
