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
            <input id="osoite" type="text" name="osoite" placeholder="kirjoita osoite" required>
            <label for="osoite" class="label">Email</label>
        </div>
        <div class="textarea_container">
            <input type="number" name="maara" id="maara" placeholder="kirjoita määrä" required>
            <label for="maara">maara</label>
        </div>
        <div class="laheta_btn">
            <input type="submit" name="laheta" value="Jatka">
        </div>
    </form>
    <?php
}
elseif($vaihe == 'vahvistus'){
    $nimi = filter($_POST['nimi']);
    $osoite = filter($_POST['osoite']);
    $maara = filter($_POST['maara']);

    $_SESSION['tilaus'] = [
        'nimi' => $nimi,
        'osoite' => $osoite,
        'maara' => $maara
    ];
}

?>