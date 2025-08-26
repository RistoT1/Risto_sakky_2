<?php
session_start();

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
        <form action="" method="post">
            <input type="hidden" name="csrf_token"
                value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

            <label for="username">Käyttäjänimi</label>
            <input type="text" id="username" name="username" placeholder="Käyttäjänimi" required>

            <label for="password">Salasana</label>
            <input type="password" id="password" name="password" placeholder="Salasana" required>

            <label for="confirm_password">Vahvista salasana</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Salasana" required>

            <input type="submit" value="Rekisteröidy"></input>
        </form>
    </div>
    <script src="./../js/signUp.js"> </script>
</body>

</html>