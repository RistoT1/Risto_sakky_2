<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ./../pages/dashboard.php");
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./../styles/form.css">
    <link rel="stylesheet" href="./../styles/main.css">
</head>

<body>
    <div class="formContainer">
        <h1>Kirjaudu</h1>
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <label for="username">Käyttäjänimi:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Salasana:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Kirjaudu"></input>
        </form>
        <p>Ei tiliä? <a href="./signUp.php">Rekisteröidy</a></p>
    </div>
    <script src="./../js/logIn.js"></script>
</body>
</html>