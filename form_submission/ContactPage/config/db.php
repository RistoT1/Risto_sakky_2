<?php
$host = 'localhost';      // because phpMyAdmin and DB are on the same server
$db   = '213603';         // your database name
$user = '213603';         // your DB username
$pass = 'a99W8zlOTOqZkb9P'; // your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Connection successful
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
