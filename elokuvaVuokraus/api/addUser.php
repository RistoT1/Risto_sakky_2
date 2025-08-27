<?php 
session_start();
require_once __DIR__ ."/../src/config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || 
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'CSRF token mismatch']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Username or password is invalid']);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Check for duplicate username (case-sensitive)
    $check = $pdo->prepare('SELECT 1 FROM jasen WHERE BINARY Kayttajatunnus = ?');
    $check->execute([$username]);
    if ($check->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Username already exists']);
        exit;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO jasen (Nimi, LiittymisPvm, SalasanaHash, Kayttajatunnus) VALUES (?, NOW(), ?, ?)'
    );
    $stmt->execute([$username, $hashedPassword, $username]);

    echo json_encode(['success' => true, 'message' => 'User registered successfully']);

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
}
