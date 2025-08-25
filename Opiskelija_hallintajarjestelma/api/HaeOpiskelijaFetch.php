<?php
require_once __DIR__ . "../../src/db.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo json_encode(["status" => "error", "message" => "Only GET requests allowed"]);
    exit;
}

$sukunimi   = $_GET["Sukunimi"] ?? null;
$sahkoposti = $_GET["Sahkoposti"] ?? null;

try {
    if ($sukunimi) {
        // Search by last name
        $stmt = $pdo->prepare("
            SELECT O.opiskelija_ID, O.Etunimi, O.Sukunimi, O.Sahkoposti,
                   k.nimi AS kurssi_nimi, k.opintopisteet
            FROM opiskelija O
            LEFT JOIN opiskelija_kurssi ok ON O.opiskelija_id = ok.opiskelija_id
            LEFT JOIN kurssi k ON k.kurssi_id = ok.kurssi_id
            WHERE LOWER(O.Sukunimi) LIKE LOWER(?)
            ORDER BY O.Etunimi ASC
        ");
        $stmt->execute(["%$sukunimi%"]);

    } elseif ($sahkoposti) {
        // Search by email
        $stmt = $pdo->prepare("
            SELECT O.opiskelija_ID, O.Etunimi, O.Sukunimi, O.Sahkoposti,
                   k.nimi AS kurssi_nimi, k.opintopisteet
            FROM opiskelija O
            LEFT JOIN opiskelija_kurssi ok ON O.opiskelija_id = ok.opiskelija_id
            LEFT JOIN kurssi k ON k.kurssi_id = ok.kurssi_id
            WHERE LOWER(O.Sahkoposti) LIKE LOWER(?)
        ");
        $stmt->execute(["%$sahkoposti%"]);

    } else {
        echo json_encode(["status" => "error", "message" => "Provide Sukunimi or Sahkoposti"]);
        exit;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $students = [];
    foreach ($rows as $row) {
        $id = $row['opiskelija_ID'];
        if (!isset($students[$id])) {
            $students[$id] = [
                "opiskelija_ID" => $id,
                "Etunimi"       => $row['Etunimi'],
                "Sukunimi"      => $row['Sukunimi'],
                "Sahkoposti"    => $row['Sahkoposti'],
                "kurssit"       => []
            ];
        }
        if ($row['kurssi_nimi']) {
            $students[$id]['kurssit'][] = [
                "nimi"         => $row['kurssi_nimi'],
                "opintopisteet"=> $row['opintopisteet']
            ];
        }
    }

    echo json_encode(["status" => "success", "data" => array_values($students)]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
