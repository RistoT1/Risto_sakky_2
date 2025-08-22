<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../nav.css">
    <link rel="stylesheet" href="../opiskelija.css">
</head>

<body class="Suoritukset">
    <?php require_once '../includes/nav.php'; ?>
    <main>
        <div class="Container">
            <div class="Page_Title">
                <h1>Suoritukset</h1>
            </div>
        </div>
        <div class="form-container">
            <form action="" class="SuorituksetForm">
                <label for="Opiskelija_select">Opiskelija</label>
                <select name="Opiskelija" id="Opiskelija_select">
                    <option value="">Valitse Opiskelija</option>
                </select>

                <label for="Kurssi_select">Kurssi</label>
                <select name="Kurssi" id="Kurssi_select">
                    <option value="">Valitse Kurssi</option>
                </select>

                <label for="Pvm">Päivämäärä</label>
                <input type="date" name="Pvm" id="Pvm" required>

                <label for="Arvosana">Arvosana</label>
                <input type="number" name="Arvosana" id="Arvosana" placeholder="Arvosana" min="0" max="5" required>

                <button type="submit">Lisää Suoritus</button>
            </form>
        </div>
        <div class="Suoritus-Info">

        </div>
    </main>
    <script src="../js/SuorituksetFetch.js"></script>
</body>

</html>