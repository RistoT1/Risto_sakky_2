<?php
session_start();

function filter($data)
{
    return htmlspecialchars(trim($data));
}

$vaihe = $_POST['vaihe'] ?? 'lomake';

if ($vaihe == 'lomake') {
    ?>
    <h2>Laku tilaus Lomake</h2>
    <form method="post">
        <div class="name_container">
            <input id="nimi" type="text" name="nimi" placeholder="Kirjoita nimi" required>
            <label for="nimi" class="label">Name</label>
        </div>
        <div class="osoite_container">
            <input id="osoite" type="text" name="osoite" autocomplete="street-address" placeholder="kirjoita osoite" required>
            <label for="osoite" class="label">osoite</label>
        </div>
        <div class="textarea_container">
            <input type="number" name="maara" id="maara" placeholder="kirjoita määrä" required>
            <label for="maara">maara</label>
        </div>
        <input type="hidden" name="vaihe" value="vahvistus">
        <div class="laheta_btn">
            <input type="submit" name="laheta" value="Jatka">
        </div>
    </form>
    <?php
} elseif ($vaihe == 'vahvistus') {
    $nimi = filter($_POST['nimi']);
    $osoite = filter($_POST['osoite']);
    $maara = filter($_POST['maara']);

    $_SESSION['tilaus'] = [
        'nimi' => $nimi,
        'osoite' => $osoite,
        'maara' => $maara
    ];
    ?>
    <h2>Vahvista tilaus</h2>
    <p><strong>Nimi:</strong><?php echo $nimi ?></p>
    <p><strong>Osoite:</strong><?php echo $osoite ?></p>
    <p><strong>Määrä:</strong><?php echo $maara ?></p>

    <form method="post">
        <input type="hidden" name="vaihe" value="valmis">
        <input type="submit" value="Vahvista tilaus">
    </form>


    <?php
} elseif ($vaihe == 'valmis') {
    $tilaus = $_SESSION['tilaus'] ?? null;

    if ($tilaus) {
        echo "<h2>Kiitos tilauksesta!</h2>";
        echo "<p><strong>" . $tilaus['nimi'] . "</strong>, tilauksesi on vastaanotettu.</p>";
        echo "<p>Toimitamme osoitteeseen: " . $tilaus['osoite'] . "</p>";
        echo "<p>Määrä: " . $tilaus['maara'] . " kpl</p>";

        unset($_SESSION['tilaus']);
    } else {
        echo "<p>Virhe: Tilauksen tietoja ei löytynyt.</p>";
    }
    echo '<br><a href="' . $_SERVER['PHP_SELF'] . '">Tee uusi tilaus</a>';
}
?>