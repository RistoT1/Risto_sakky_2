<?php 
require_once __DIR__ . "../../src/db.php"; 
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sukunimi = $_GET["Sukunimi"] ?? null;
    $sahkoposti = $_GET["Sahkoposti"] ?? null;

    if ($sukunimi) {
        $stmt = $pdo->prepare("
            SELECT opiskelija_ID, Etunimi, Sukunimi, Sahkoposti
            FROM opiskelija
            WHERE LOWER(Sukunimi) = LOWER(?)
            ORDER BY Etunimi ASC
        ");
        $stmt->execute(["%$sukunimi%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "success", "data" => $result]);
    } elseif ($sahkoposti) {
        $stmt = $pdo->prepare("
            SELECT opiskelija_ID, Etunimi, Sukunimi, Sahkoposti
            FROM opiskelija
            WHERE LOWER(Sahkoposti) = LOWER(?)
        ");
        $stmt->execute(["%$sahkoposti%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "success", "data" => $result]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
        exit;
    }
}

?>