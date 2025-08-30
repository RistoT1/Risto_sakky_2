<?php 
session_start();
require_once __DIR__ ."/../../src/config.php";
header('Content-Type: application/json');

if (empty($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':        
        break;

    case 'GET':
        try {
            $searchValue = trim($_GET['search'] ?? '');
            if ($searchValue !== '') {
                $stmt = $pdo->prepare('SELECT * FROM jasen WHERE Kayttajatunnus LIKE ?');
                $stmt->execute(['%' . $searchValue . '%']);
            } else {
                $stmt = $pdo->prepare('SELECT * FROM jasen');
                $stmt->execute();
            }
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'users' => $users]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
        break;

    case 'DELETE':
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
        break;
}
?>