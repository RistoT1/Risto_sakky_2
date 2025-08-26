<?php
session_start();

// Redirect to login if user is not logged in or CSRF token is missing
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || !isset($_SESSION['csrf_token'])) {
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="./../styles/main.css">
    <link rel="stylesheet" href="./../styles/form.css">
    <link rel="stylesheet" href="./../styles/dashboard.css">
    <link rel="stylesheet" href="./../styles/button.css">
</head>

<body>
    <div class="container">
        <div class="formContainer">
            <h1>Dashboard</h1>
            <p>Vuokraa elokuva!</p>
            <form action="rentMovie.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <label for="movie">Elokuva:</label>
                <select id="movie" name="movie">
                    <option value="0">Valitse elokuva</option>
                </select>
                <input type="submit" value="Vuokraa"></input>
            </form>
        </div>
        <button id="logoutBtn">Logout</button>
        <div class="rentedMovies">
            <h2>Omat vuokraukset</h2>
            <div id="rentedMovies">
                
            </div>

        </div>
    </div>
    <script src="./../js/fetchMovies.js"></script>
</body>

</html>