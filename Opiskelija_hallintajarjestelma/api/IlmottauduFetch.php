<?php
require_once __DIR__ . "../../src/db.php"; // adjust path if needed
header("Content-Type: application/json; charset=UTF-8");

try {

    if ($_SERVER["REQUEST_METHOD"] === "GET") {

        $kurssit = $pdo->query("
            SELECT Kurssi_ID, Nimi
            FROM kurssi
            ORDER BY Nimi ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $opiskelijat = $pdo->query("
            SELECT  Opiskelija_ID, CONCAT(Etunimi, ' ', Sukunimi) AS Nimi
            FROM opiskelija
            ORDER BY Etunimi ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => "onnistui",
            "kurssit" => $kurssit,
            "opiskelijat" => $opiskelijat
        ]);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['Kurssi_ID'], $input['Opiskelija_ID'])) {
            echo json_encode([
                "status" => "virhe",
                "message" => "Puuttuvat vaaditut kentät."
            ]);
            exit;
        }

        $kurssi_id = (int) $input['Kurssi_ID'];
        $opiskelija_id = (int) $input['Opiskelija_ID'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM kurssi WHERE Kurssi_ID = ?");
        $stmt->execute([$kurssi_id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode([
                "status" => "virhe",
                "message" => "Kurssia ei löydy."
            ]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM opiskelija WHERE Opiskelija_ID = ?");
        $stmt->execute([$opiskelija_id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode([
                "status" => "virhe",
                "message" => "Opiskelijaa ei löydy."
            ]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM opiskelija_kurssi WHERE Kurssi_ID = ? AND Opiskelija_ID = ?");
        $stmt->execute([$kurssi_id, $opiskelija_id]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode([
                "status" => "virhe",
                "message" => "Opiskelija on jo ilmoittautunut tälle kurssille."
            ]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO opiskelija_kurssi (Kurssi_ID, Opiskelija_ID) VALUES (?, ?)");
        $stmt->execute([$kurssi_id, $opiskelija_id]);

        echo json_encode([
            "status" => "onnistui",
            "message" => "Ilmoittautuminen onnistui."
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
