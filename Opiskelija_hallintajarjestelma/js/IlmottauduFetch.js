document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('IlmottauduForm');
    const infoContainer = document.querySelector('.Ilmottautumis-Info');
    const kurssiSelect = document.getElementById('Kurssi_select');
    const opiskelijaSelect = document.getElementById('Opiskelija_select');

    async function fetchOptions() {
        try {
            const response = await fetch('../api/IlmottauduFetch.php');
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();

            if (data.status === 'onnistui') {
                for (const kurssi of data.kurssit) {
                    const option = document.createElement('option');
                    option.value = kurssi.Kurssi_ID; 
                    option.textContent = kurssi.Nimi;
                    kurssiSelect.appendChild(option);
                }

                for (const opiskelija of data.opiskelijat) {
                    const option = document.createElement('option');
                    option.value = opiskelija.Opiskelija_ID; 
                    option.textContent = opiskelija.Nimi;
                    opiskelijaSelect.appendChild(option);
                }
            } else {
                console.error('Virhe vaihtoehtoja haettaessa:', data);
            }

        } catch (error) {
            console.error('Virhe vaihtoehtoja haettaessa:', error);
        }
    }

    async function ilmottauduKurssille(data) {
        try {
            const response = await fetch('../api/IlmottauduFetch.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

            const result = await response.json();
            infoContainer.textContent = result.message || 'Ilmoittautuminen onnistui!';
        } catch (error) {
            console.error('Virhe ilmoittautumisessa:', error);
            infoContainer.textContent = 'Virhe ilmoittautumisessa. Yritä uudelleen.';
        }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const data = {
            Kurssi_ID: parseInt(kurssiSelect.value), // match PHP expected field
            Opiskelija_ID: parseInt(opiskelijaSelect.value)
        };

        await ilmottauduKurssille(data);
        form.reset();
    });

    fetchOptions();
});
