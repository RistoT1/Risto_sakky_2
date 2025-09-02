// kassa.js
(async () => {
    try {
        const customerData = JSON.parse(sessionStorage.getItem("customerData"));
        const orderSummary = document.getElementById("orderSummary");

        if (!customerData) {
            orderSummary.innerHTML = "<p>Ei asiakastietoja.</p>";
            return;
        }

        // Fetch cart items from PHP
        const res = await fetch("../api/fetchCart.php");
        const data = await res.json();

        if (!data.success || !data.items || data.items.length === 0) {
            orderSummary.innerHTML = "<p>Ostoskorisi on tyhjä.</p>";
            return;
        }

        const cartItems = data.items;

        // Build order summary
        let html = `<h2>Asiakas</h2>
            <p>${customerData.Enimi} ${customerData.Snimi}</p>
            <p>${customerData.email}, ${customerData.puhelin}</p>
            <p>${customerData.osoite}, ${customerData.posti} ${customerData.kaupunki}</p>
            <h2>Tuotteet</h2><ul>`;

        cartItems.forEach(item => {
            html += `<li>${item.Nimi} (${item.sizeName}) × ${item.quantity} — €${item.price.toFixed(2)}</li>`;
        });

        html += "</ul>";
        orderSummary.innerHTML = html;

        // Handle payment button
        document.getElementById("payBtn").addEventListener("click", async () => {
            // Haetaan CSRF-token meta-tagista
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch("../api/insertTilaus.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                credentials: "same-origin",
                body: JSON.stringify({ 
                    ...customerData,
                    csrf_token: csrfToken // lähetetään token serverille
                })
            });

            const result = await response.json();
            if (result.success) {
                alert("Tilaus vastaanotettu! Kiitos.");
                sessionStorage.removeItem("customerData");
                window.location.href = "../index.php";
            } else {
                alert("Virhe: " + result.message);
            }
        });

    } catch (err) {
        console.error("Virhe ladattaessa tilausdataa:", err);
        document.getElementById("orderSummary").innerHTML = "<p>Virhe ladattaessa tilausdataa.</p>";
    }
})();
