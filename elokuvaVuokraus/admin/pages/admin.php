<?php
session_start();
session_regenerate_id(true);

// Redirect to login if user is not logged in or CSRF token is missing
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ./../index.php'); // adjust path if needed
    exit;
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="./../../styles/main.css">
    <link rel="stylesheet" href="./../../styles/form.css">
    <link rel="stylesheet" href="./../../styles/dashboard.css">
    <link rel="stylesheet" href="./../../styles/button.css">
    <link rel="stylesheet" href="./../../styles/nav.css">
</head>

<body>
    <?php require_once __DIR__ . '/../../includes/nav.php'; ?>
    <div class="container">
        <div class="content">
            <h1>Admin Paneli</h1>
            <p>hallitsse elokuvia täällä</p>
            <input type="text" id="search" placeholder="Hae käyttäjä...">
            <div id="results"></div>
        </div>
    <script>
        window.csrfToken = "<?php echo $csrf_token; ?>";
    </script>
    <script src="./../js/fetchUsers.js"></script>
</body>

</html>