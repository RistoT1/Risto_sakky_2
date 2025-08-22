<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../nav.css">
    <link rel="stylesheet" href="../opiskelija.css">
</head>

<body class="Opiskelijat">
    <?php require_once '../includes/nav.php'; ?>
    <main>
        <div class="Container">
            <div class="Page_Title">
                <h1>Opiskelijat</h1>
            </div>
        </div>
        <div class="form-container">
            <form id="OpiskelijaForm">
                <label for="Etunimi">Etunimi</label>
                <input type="text" name="Etunimi" id="Etunimi" placeholder="Opiskelijan etunimi" required>
                <label for="Sukunimi">Sukunimi</label>
                <input type="text" name="Sukunimi" id="Sukunimi" placeholder="Opiskelijan sukunimi" required>
                <label for="Sahkoposti">Sähköposti</label>
                <input type="email" name="Sahkoposti" id="Sahkoposti" placeholder="Opiskelijan Sähköposti" required>
                <label for="SyntymaAika">Syntymäaika</label>
                <input type="date" name="SyntymaAika" id="SyntymaAika" value="2001-09-11" required>
                <button type="submit">Lisää Opiskelija</button>
            </form>

        </div>
        <div class="Opiskelija-Info" id="OpiskelijaInfo">
            <h2>Opiskelijat</h2>
            <p>Tähän tulee lista opiskelijoista.</p>
        </div>
    </main>
    <script src="../js/OpiskelijaFetch.js"></script>
</body>

</html>