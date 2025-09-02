<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indeksi sivu</title>
    <style>
        .hero-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 50px;
        }

        .auto-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2px;
            max-width: 300px;
        }

        .grid-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* 3 columns: Merkki, Tyyppi, Vuosimalli */
            padding: 8px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }

        .grid-row.header {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .auto-search-container {
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <div class="hero-container">
                <div class="auto-grid-container">
                    <div class="grid-row header">
                        <div>ID</div>
                        <div>Merkki</div>
                        <div>Tyyppi</div>
                        <div>Vuosimalli</div>
                    </div>
                    <div class="auto-grid" id="grid">

                    </div>
                </div>
                <div class="auto-search-container">
                    <input type="number" name="auto-search" id="auto-search" min="1" max="9999">
                </div>
            </div>
            <div class="form-container">
                <h2>Uusi Auto</h2>
                <form id="auto-form">
                    <label for="merkki">Merkki</label>
                    <input type="text" id="merkki" name="merkki" required>

                    <label for="tyyppi">Tyyppi</label>
                    <input type="text" id="tyyppi" name="tyyppi" required>

                    <label for="vuosimalli">Vuosimalli</label>
                    <input type="number" id="vuosimalli" name="vuosimalli" min="1900" max="2099" required>

                    <button type="submit">Insert Auto</button>
                </form>
            </div>
        </div>
    </main>
    <script src="fetchAutot.js"></script>
</body>

</html>