document.addEventListener('DOMContentLoaded', () => {
  const kurssitContainer = document.getElementById('KurssiInfo'); // container for courses
  const form = document.getElementById('KurssiForm');

  // Fetch existing courses
  async function fetchKurssit() {
    try {
      const response = await fetch('../api/KurssiFetch.php');
      if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

      const result = await response.json();

      if (result.status === 'success' && Array.isArray(result.data)) {
        kurssitContainer.innerHTML = ''; 

        result.data.forEach(kurssi => {
          const div = document.createElement('div');
          div.classList.add('kurssi');
          div.innerHTML = `
            <h3>${kurssi.Kurssikoodi}: ${kurssi.Nimi}</h3>
            <p>Opintopisteet: ${kurssi.Opintopisteet}</p>
          `;
          kurssitContainer.appendChild(div);
        });
      } else {
        console.error('No kurssit found or invalid format:', result);
      }
    } catch (error) {
      console.error('Error fetching kurssit:', error);
    }
  }

  // Insert a new course
  async function insertKurssi(data) {
    try {
      const response = await fetch('../api/KurssiFetch.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

      const result = await response.json();
      console.log('Kurssi added:', result);
    } catch (error) {
      console.error('Error adding kurssi:', error);
    }
  }

  // Form submit handler
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const data = {
      Kurssikoodi: formData.get('Kurssikoodi'),
      KurssiNimi: formData.get('KurssiNimi'),
      Opintopisteet: formData.get('Opintopisteet')
    };

    await insertKurssi(data);
    form.reset();
    await fetchKurssit();
  });

  fetchKurssit(); 
});
