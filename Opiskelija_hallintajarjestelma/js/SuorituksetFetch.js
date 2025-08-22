document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.SuorituksetForm');
    const infoContainer = document.querySelector('.Suoritus-Info');

    const kurssiSelect = document.getElementById('Kurssi_select');
    const opiskelijaSelect = document.getElementById('Opiskelija_select');

    async function fetchStudents() {
        try {
            const response = await fetch('../api/SuorituksetFetch.php');
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();

            if (data.status === 'onnistui') {

                for (const opiskelija of data.opiskelijat) {
                    const option = document.createElement('option');
                    option.value = opiskelija.Opiskelija_ID;
                    option.textContent = opiskelija.Nimi;
                    opiskelijaSelect.appendChild(option);
                }
            } else {
                console.error('Virhe opiskelijoita haettaessa:', data);
                infoContainer.textContent = 'Virhe opiskelijoita haettaessa.';
            }

        } catch (error) {
            console.error('Virhe opiskelijoita haettaessa:', error);
            infoContainer.textContent = 'Virhe opiskelijoita haettaessa.';
        }
    }

    async function fetchCourses(studentId) {
        kurssiSelect.innerHTML = '<option value="">Valitse Kurssi</option>'; // reset courses
        if (!studentId) return;

        try {
            const response = await fetch(`../api/SuorituksetFetch.php?Opiskelija_ID=${studentId}`);
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();

            if (data.status === 'onnistui') {
                for (const kurssi of data.kurssit) {
                    const option = document.createElement('option');
                    option.value = kurssi.Kurssi_ID;
                    option.textContent = kurssi.Nimi;
                    kurssiSelect.appendChild(option);
                }
            }
        } catch (error) {
            console.error('Virhe kurssien haussa:', error);
            infoContainer.textContent = 'Virhe kurssien haussa.';
        }
    }

    opiskelijaSelect.addEventListener('change', (e) => {
        const studentId = parseInt(e.target.value);
        if (!isNaN(studentId)) {
            fetchCourses(studentId);
        } else {
            kurssiSelect.innerHTML = '<option value="">Valitse Kurssi</option>'; // reset if invalid
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const data = {
            Kurssi_ID: parseInt(kurssiSelect.value),
            Opiskelija_ID: parseInt(opiskelijaSelect.value),
            Pvm: document.getElementById('Pvm').value,
            Arvosana: parseInt(document.getElementById('Arvosana').value)
        };

        try {
            const response = await fetch('../api/SuorituksetFetch.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            infoContainer.textContent = result.message || 'Suoritus tallennettu onnistuneesti.';
            form.reset();
            kurssiSelect.innerHTML = '<option value="">Valitse Kurssi</option>'; // reset courses
        } catch (error) {
            console.error('Virhe ilmoittautumisessa:', error);
            infoContainer.textContent = 'Virhe ilmoittautumisessa.';
        }
    });

    fetchStudents();
});
