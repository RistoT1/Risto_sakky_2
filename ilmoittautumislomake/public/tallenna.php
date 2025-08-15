<?php
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Virheellinen pyyntö."
    ]);
    exit;
}

if (
    empty($_POST["etunimi"]) ||
    empty($_POST["sukunimi"]) ||
    empty($_POST["sahkoposti"]) ||
    empty($_POST["puhelinnumero"]) ||
    empty($_POST["kurssi"])
) {
    echo json_encode([
        "success" => false,
        "message" => "Kaikki kentät ovat pakollisia."
    ]);
    exit;
}

$etunimi       = htmlspecialchars(trim($_POST["etunimi"]));
$sukunimi      = htmlspecialchars(trim($_POST["sukunimi"]));
$email         = trim($_POST["sahkoposti"]);
$puhelinnumero = trim($_POST["puhelinnumero"]);
$kurssi        = trim($_POST["kurssi"]);

require_once '../src/config/db.php';

try {
    $stmt = $pdo->prepare(
        "INSERT INTO ilmottautumiset (etunimi, sukunimi, email, puhelin, kurssi) 
         VALUES (?, ?, ?, ?, ?)"
    );
    $success = $stmt->execute([$etunimi, $sukunimi, $email, $puhelinnumero, $kurssi]);

    if ($success) {
        echo json_encode([
            "success" => true,
            "message" => "Ilmoittautuminen onnistui."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Ilmoittautuminen epäonnistui. Tarkista syötteesi."
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Tietokantavirhe: " . $e->getMessage()
    ]);
}
?>
