<?php
session_start();
require_once __DIR__ . "/../src/config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

try {
    $stmt = $pdo->query("SELECT ElokuvaID, Nimi FROM elokuva");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $movies
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
