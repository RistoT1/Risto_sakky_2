<?php
require_once __DIR__ . "../../src/db.php"; 
header("Content-Type: application/json; charset=UTF-8");

try {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {

        $opiskelijat = $pdo->query("
            SELECT Opiskelija_ID, CONCAT(Etunimi, ' ', Sukunimi) AS Nimi
            FROM opiskelijat
            ORDER BY Etunimi ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $studentId = isset($_GET['Opiskelija_ID']) ? (int) $_GET['Opiskelija_ID'] : null;
        $kurssit = [];

        if ($studentId) {
            $stmt = $pdo->prepare("
                SELECT k.Kurssi_ID, k.Nimi
                FROM kurssit k
                INNER JOIN opiskelija_kurssi ok ON k.Kurssi_ID = ok.Kurssi_ID
                WHERE ok.Opiskelija_ID = ?
                ORDER BY k.Nimi ASC
            ");
            $stmt->execute([$studentId]);
            $kurssit = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        echo json_encode([
            "status" => "onnistui",
            "kurssit" => $kurssit,
            "opiskelijat" => $opiskelijat
        ]);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['Kurssi_ID'], $input['Opiskelija_ID'], $input['Arvosana'], $input['Pvm'])) {
            echo json_encode([
                "status" => "virhe",
                "message" => "Puuttuvat vaaditut kentät."
            ]);
            exit;
        }

        $kurssi_id = (int) $input['Kurssi_ID'];
        $opiskelija_id = (int) $input['Opiskelija_ID'];
        $arvosana = (int) $input['Arvosana'];
        $pvm = $input['Pvm'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM kurssit WHERE Kurssi_ID = ?");
        $stmt->execute([$kurssi_id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(["status" => "virhe", "message" => "Kurssia ei löydy."]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM opiskelijat WHERE Opiskelija_ID = ?");
        $stmt->execute([$opiskelija_id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(["status" => "virhe", "message" => "Opiskelijaa ei löydy."]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM opiskelija_kurssi WHERE Kurssi_ID = ? AND Opiskelija_ID = ?");
        $stmt->execute([$kurssi_id, $opiskelija_id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(["status" => "virhe", "message" => "Opiskelija ei ole ilmoittautunut tälle kurssille."]);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO suoritukset (Kurssi_ID, Opiskelija_ID, Pvm, Arvosana)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE Pvm = VALUES(Pvm), Arvosana = VALUES(Arvosana)
        ");
        $stmt->execute([$kurssi_id, $opiskelija_id, $pvm, $arvosana]);

        echo json_encode([
            "status" => "onnistui",
            "message" => "Suoritus tallennettu onnistuneesti."
        ]);
        exit;
    }

    echo json_encode([
        "status" => "virhe",
        "message" => "Tuntematon pyyntömetodi."
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "virhe",
        "message" => "Tietokantavirhe: " . $e->getMessage()
    ]);
}
