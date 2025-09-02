<?php
session_start();
require '../src/config.php';

// Tarkista onko ostoskori olemassa ja siinä tuotteita
if (!isset($_SESSION['cartID']) || empty($_SESSION['cartID'])) {
    header("Location: index.php");
    exit;
}

$cartID = $_SESSION['cartID'];
$stmt = $pdo->prepare("SELECT COUNT(*) FROM ostoskori_rivit WHERE OstoskoriID = ?");
$stmt->execute([$cartID]);
$cartItemCount = $stmt->fetchColumn();

if (!$cartItemCount) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Kassa - Sakky Pizzeria</title>
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
</head>
<body>
    <h1>Kassa</h1>
    <div id="orderSummary"></div>
    <button id="payBtn">Maksa nyt</button>

    <script src="../js/kassa.js"></script>
</body>
</html>