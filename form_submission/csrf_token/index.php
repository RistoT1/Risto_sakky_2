<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="form-container">
        <form action="tarkistus.php" method="POST">
            <label for="nimi">Nimi:</label>
            <input type="text" name="nimi" required>

            <label for="sahkoposti">Sähköposti</label>
            <input type="email" name="sahkoposti" required>

            <?php
                session_start();
                $csrf_token = bin2hex(random_bytes(32));
                $_SESSION['csrf_token'] = $csrf_token;
            ?>
            <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
            
            <input type="submit" value="lähetä">
        </form>
    </div>
</body>
</html>