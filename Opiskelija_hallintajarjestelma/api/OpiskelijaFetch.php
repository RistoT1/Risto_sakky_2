<?php
require_once __DIR__ . "../../src/db.php";
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['Etunimi'], $input['Sukunimi'], $input['Sahkoposti'], $input['Syntymaika'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Missing required fields."
        ]);
        exit;
    }

    $etunimi = htmlspecialchars(trim($input['Etunimi']));
    $sukunimi = htmlspecialchars(trim($input['Sukunimi']));
    $sahkoposti = htmlspecialchars(trim($input['Sahkoposti']));
    $syntymapaiva = htmlspecialchars(trim($input['Syntymaika']));

    try {
        $stmt = $pdo->prepare("INSERT INTO Opiskelija (Etunimi, Sukunimi, Sahkoposti, Syntymaika) VALUES (?, ?, ?, ?)");
        $stmt->execute([$etunimi, $sukunimi, $sahkoposti, $syntymapaiva]);

        echo json_encode([
            "status" => "success",
            "message" => "Opiskelija lisätty onnistuneesti."
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
        $stmt = $pdo->query("SELECT * FROM opiskelija ORDER BY LuontiPvm DESC limit 25" );
        $opiskelijat = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => "success",
            "data" => $opiskelijat
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Tietokantavirhe: " . $e->getMessage()
        ]);
    }
}
?>
