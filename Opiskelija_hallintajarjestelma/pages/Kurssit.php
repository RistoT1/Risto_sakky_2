<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../nav.css">
    <link rel="stylesheet" href="../form.css">
</head>
<body class="Kurssit">
    <?php require_once '../includes/nav.php'; ?>
    <main>
        <div class="Container">
            <div class="Page_Title">
                <h1>Kurssit</h1>
            </div>
        </div>
        <div class="form-container">
            <form id="KurssiForm">
                <label for="Kurssikoodi">Kurssi koodi</label>
                <input type="text" name="Kurssikoodi" id="Kurssikoodi" placeholder="Kurssin koodi" required>
                <label for="KurssinNimi">Kurssin Nimi</label>
                <input type="text" name="KurssiNimi" id="KurssiNimi" placeholder="Kurssin nimi" required>
                <label for="Opintopisteet">Opintopisteet</label>
                <input type="number" name="Opintopisteet" id="Opintopisteet" placeholder="Opintopisteet" required>
                <button type="submit">Lisää</button>
            </form>
        </div>
        <div class="KurssiInfo" id="KurssiInfo"></div>
    </main>
    <script src="../js/KurssiFetch.js"></script>
</body>
</html>