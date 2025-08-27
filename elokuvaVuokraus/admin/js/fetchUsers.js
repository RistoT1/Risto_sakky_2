const resultContainer = document.getElementById('results');
const searchInput = document.getElementById('search');

const fetchUsers = async () => {
    const searchValue = searchInput.value.trim(); // ✅ get the value
    if (!searchValue) return;

    try {
        const response = await fetch(`fetchUsers.php?searchValue=${encodeURIComponent(searchValue)}`, {
            method: 'GET',
            credentials: 'include', // important to send cookies
            headers: { 'Content-Type': 'application/json' }
        });

        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

        const data = await response.json();
        displayUsers(data.users);
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

searchInput.addEventListener('input', fetchUsers);

const displayUsers = (users) => {
    resultContainer.innerHTML = ''; // Clear previous content

    if (!users.length) {
        const p = document.createElement('p');
        p.textContent = 'No users found.';
        resultContainer.appendChild(p);
        return;
    }

    // Create table
    const table = document.createElement('table');

    // Create table head
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    ['ID', 'Username', 'Email', 'Created At', 'Admin'].forEach(text => {
        const th = document.createElement('th');
        th.textContent = text;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Create table body
    const tbody = document.createElement('tbody');
    users.forEach(user => {
        const tr = document.createElement('tr');

        const tdID = document.createElement('td');
        tdID.textContent = user.JasenID;
        tr.appendChild(tdID);

        const tdUsername = document.createElement('td');
        tdUsername.textContent = user.Kayttajanimi;
        tr.appendChild(tdUsername);

        const tdEmail = document.createElement('td');
        tdEmail.textContent = user.Sposti;
        tr.appendChild(tdEmail);

        const tdCreated = document.createElement('td');
        tdCreated.textContent = user.Luontiaika;
        tr.appendChild(tdCreated);

        const tdAdmin = document.createElement('td');
        tdAdmin.textContent = user.is_admin ? 'Yes' : 'No';
        tr.appendChild(tdAdmin);

        tbody.appendChild(tr);
    });
    table.appendChild(tbody);

    // Append table to container
    resultContainer.appendChild(table);
};
