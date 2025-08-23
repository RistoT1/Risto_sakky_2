<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../nav.css">
    <link rel="stylesheet" href="../form.css">
    <link rel="stylesheet" href="../body.css">
</head>

<body class="Suoritukset">
    <?php require_once '../includes/nav.php'; ?>
    <main>
        <div class="Container">
            <div class="Page_Title">
                <h1>Suoritukset</h1>
            </div>
        </div>
        <button class="haeBtn active" data-type="sukunimi">Hae sukunimellä</button>
        <button class="haeBtn" data-type="numero">Hae sähköpostilla</button>

        <div class="form-container">
            <form id="HaeForm" class="SuorituksetForm">
                <label id="formLabel" for="inputField">Opiskelijan sukunimi</label>
                <input type="text" id="inputField" placeholder="Opiskelijan sukunimi" required>
                <button type="submit">Hae opiskelija</button>
            </form>
        </div>
        <div class="Suoritus-Info">

        </div>
    </main>
    <script src="../js/HaeOpiskelija.js"></script>
</body>

</html>