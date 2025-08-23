<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../nav.css">
    <link rel="stylesheet" href="../form.css">
</head>

<body class="Ilmottaudu">
    <?php require_once '../includes/nav.php'; ?>
    <main>
        <div class="Container">
            <div class="Page_Title">
                <h1>Ilmottaudu</h1>
            </div>
        </div>
        <div class="form-container">
            <form id="IlmottauduForm">
                <label for="Kurssi_select">Kurssi</label>
                <select name="Kurssi" id="Kurssi_select">
                    <option value="">Valitse Kurssi</option>
                </select>
                <label for="Opiskelija_select">Opiskelija</label>
                <select name="Opiskelija" id="Opiskelija_select">
                    <option value="">Valitse Opiskelija</option>
                </select>
                <input type="submit" value="Ilmottaudu Kurssille">
            </form>
        </div>
        <div class="Ilmottautumis-Info">

        </div>
    </main>
    <script src="../js/IlmottauduFetch.js"></script>
</body>

</html>