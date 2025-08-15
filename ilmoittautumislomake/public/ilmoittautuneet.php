<?php
header("Content-Type: application/json; charset=utf-8");
require_once("../src/config/db.php");

try {
$stmt = $pdo->prepare("SELECT * FROM ilmottautumiset ORDER BY id DESC");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
    $ilmoittautumiset = [];
    foreach ($result as $row) {
        $ilmoittautumiset[] = [
            "id" => $row["id"],
            "etunimi" => $row["etunimi"],
            "sukunimi" => $row["sukunimi"],
            "email" => $row["email"],
            "puhelin" => $row["puhelin"],
            "kurssi" => $row["kurssi"]
        ];
    }
    echo json_encode([
        "success" => true,
        "ilmoittautumiset" => $ilmoittautumiset
    ]);
}
else {
    echo json_encode([
        "success" => false,
        "message" => "Ei ilmoittautumisia."
    ]);
}
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Tietokantavirhe: " . $e->getMessage()
    ]);
}
?>