<?php
require_once __DIR__ . "../../src/db.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['Kurssikoodi'], $input['KurssiNimi'], $input['Opintopisteet'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Missing required fields."
        ]);
        exit;
    }

    $kurssikoodi = htmlspecialchars(trim($input['Kurssikoodi']));
    $kurssiNimi = htmlspecialchars(trim($input['KurssiNimi']));
    $opintopisteet = htmlspecialchars(trim($input['Opintopisteet']));

    try {
        $stmt = $pdo->prepare("INSERT INTO kurssit (Kurssikoodi, Nimi, Opintopisteet) VALUES (?, ?, ?)");
        $stmt->execute([$kurssikoodi, $kurssiNimi, $opintopisteet]);

        echo json_encode([
            "status" => "success",
            "message" => "Kurssi lisätty onnistuneesti."
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Tietokantavirhe: " . $e->getMessage()
        ]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    try {
        $stmt = $pdo->query("SELECT * FROM kurssit ORDER BY LuontiPvm DESC LIMIT 25");
        $kurssit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => "success",
            "data" => $kurssit
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Tietokantavirhe: " . $e->getMessage()
        ]);
    }
}
?>
