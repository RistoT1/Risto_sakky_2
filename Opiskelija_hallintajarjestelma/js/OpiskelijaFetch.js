document.addEventListener('DOMContentLoaded', () => {
  const opiskelijat = document.getElementById('OpiskelijaInfo');
  const form = document.getElementById('OpiskelijaForm');

  async function fetchOpiskelijat() {
    try {
      const response = await fetch('../api/OpiskelijaFetch.php');
      if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

      const result = await response.json();

      if (result.status === 'success' && Array.isArray(result.data)) {
        opiskelijat.innerHTML = ''; 

        result.data.forEach(opiskelija => {
          const div = document.createElement('div');
          div.classList.add('opiskelija');
          div.innerHTML = `
            <h3>${opiskelija.Etunimi} ${opiskelija.Sukunimi}</h3>
            <p>Sähköposti: ${opiskelija.Sahkoposti}</p>
            <p>Syntymäaika: ${opiskelija.SyntymaAika}</p>
          `;
          opiskelijat.appendChild(div);
        });
      } else {
        console.error('No opiskelijat found or invalid format:', result);
      }
    } catch (error) {
      console.error('Error fetching opiskelijat:', error);
    }
  }

  async function insertOpiskelija(data) {
    try {
      const response = await fetch('../api/OpiskelijaFetch.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

      const result = await response.json();
      console.log('Opiskelija added:', result);
    } catch (error) {
      console.error('Error adding opiskelija:', error);
    }
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const data = {
      Etunimi: formData.get('Etunimi'),
      Sukunimi: formData.get('Sukunimi'),
      Sahkoposti: formData.get('Sahkoposti'),
      SyntymaAika: formData.get('SyntymaAika')
    };

    await insertOpiskelija(data);
    form.reset();
    await fetchOpiskelijat();
  });

  fetchOpiskelijat(); 
});
