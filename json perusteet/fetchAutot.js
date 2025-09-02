const grid = document.getElementById("grid")
const search = document.getElementById("auto-search")
const form = document.getElementById("auto-form")
const fetchAutot = async () => {
    try {
        console.log("jooo")
        const response = await fetch('autot_api.php', {
            method: "GET",
            headers: { 'Content-Type': 'application/json' },
        });
        if (!response.ok) {
            throw new Error('Network error fetching autot')
        }
        const result = await response.json();
        renderCar(result);

    } catch (err) {
        console.log(err)
    }
}

const renderCar = (result) => {
    grid.innerHTML ="";
    if (result.length) {

        const fragment = document.createDocumentFragment();
        for (const auto of result) {
            const autoRow = document.createElement("div");
            autoRow.className = "grid-row";
            autoRow.innerHTML = `
                    <div>${auto["ID"]}</div>
                    <div>${auto["Merkki"]}</div>
                    <div>${auto["Tyyppi"]}</div>
                    <div>${auto["Vuosimalli"]}</div>
                `;
            fragment.appendChild(autoRow);
        }

        const grid = document.getElementById("grid");
        grid.appendChild(fragment);
    }
}

search.addEventListener('change', async () => { // make async
    const searchValue = search.value || null;

    if (!searchValue || isNaN(searchValue)) {
        fetchAutot();
    }

    try {
        const response = await fetch(`autot_api.php?id=${encodeURIComponent(searchValue)}`, {
            method: "GET",
            headers: { 'Content-Type': 'application/json' }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();
        renderCar(result);

    } catch (error) {
        console.error('Fetch error:', error);
    }
});

form.addEventListener('submit', (e) =>{
    e.preventDefault;
    try {
        const response = fetch(`autot_api.php?`, {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            //how ytpo get input
        });
    }catch{

    }
})


fetchAutot();