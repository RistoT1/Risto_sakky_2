<?php

header("Content-Type: application/json; charset=UTF-8");
include 'config.php';
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            getAuto($pdo, intval($_GET['id']));
        }
        else {
            getAllAutot($pdo);
        }
        break;

    case 'POST':
        if (strpos($_SERVER['CONTENT_TYPE'], 'application/json') === 0) {
            addAuto($pdo);
        } else {
            http_response_code(415);
            echo json_encode(['Message' => 'Tietotyyppi virhe!']);
        }
        break;
    case 'PUT':
        break;

    case 'DELETE':
        break;

    default:
        break;
}

function getAllAutot($pdo)
{
    $stmt = $pdo->prepare('SELECT ID, Merkki, Tyyppi, Vuosimalli FROM autot');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

function getAuto($pdo, $id)
{
    $stmt = $pdo->prepare('SELECT ID, Merkki, Tyyppi,Vuosimalli FROM autot WHERE ID = ?');
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 1) {
        echo json_encode($result);
    } else {
        echo json_encode([]);
    }
}

function addAuto($pdo)
{
    $data = json_decode(file_get_contents("php://input"), true);


    if (empty($data["Merkki"]) || empty($data["Tyyppi"]) || empty($data["Vuosimalli"])) {
        http_response_code(400);
        echo json_encode(["Message" => "Tietoja puuttuu"]);
    }
    $merkki = $data["Merkki"];
    $tyyppi = $data["Tyyppi"];
    $vuosimalli = $data["Vuosimalli"];

    try {
        $stmt = $pdo->prepare("INSERT INTO autot (Merkki, Tyyppi, Vuosimalli) VALUES (?, ?, ?)");
        $stmt->execute([$merkki, $tyyppi, $vuosimalli]);
        echo json_encode(["Message" => "Tiedot lisätty onnistuneesti"]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["Message" => "Tietokanta virhe"]);
    }
}
?>