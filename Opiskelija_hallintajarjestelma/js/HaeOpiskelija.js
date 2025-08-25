const buttons = document.querySelectorAll(".haeBtn");
const label = document.getElementById("formLabel");
const input = document.getElementById("inputField");
const form = document.getElementById("HaeForm");

for (const btn of buttons) {
    btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");

        if (btn.dataset.type === "sukunimi") {
            label.textContent = "Opiskelijan sukunimi";
            input.placeholder = "Opiskelijan sukunimi";
            input.name = "Sukunimi";
            input.type = "text";
        } else {
            label.textContent = "Opiskelijan sähköposti";
            input.placeholder = "Opiskelijan sähköposti";
            input.name = "Sahkoposti";
            input.type = "email";
        }
    });
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const queryString = new URLSearchParams(formData).toString();

    try {
        const response = await fetch(`../api/HaeOpiskelijaFetch.php?${queryString}`);
        const data = await response.json();

        if (!response.ok) {
            console.error("Network error:", response.status, data);
            return;
        }

        const resultsContainer = document.getElementById("Suoritus-Info");
        resultsContainer.innerHTML = ""; // Clear previous results

        if (data.status === "success") {
            // Check if any students were returned
            if (!data.data || data.data.length === 0) {
                const noResults = document.createElement("p");
                noResults.textContent = "Ei tuloksia."; // "No results"
                resultsContainer.appendChild(noResults);
                return;
            }

            console.log("Fetched data:", data);

            for (const opiskelija of data.data) {
                const div = document.createElement("div");
                div.classList.add("opiskelija");

                // Student info
                const info = document.createElement("p");
                info.textContent = `${opiskelija.Etunimi} ${opiskelija.Sukunimi} (${opiskelija.Sahkoposti})`;
                div.appendChild(info);

                // Courses list
                if (opiskelija.kurssit && opiskelija.kurssit.length > 0) {
                    const ul = document.createElement("ul");
                    for (const kurssi of opiskelija.kurssit) {
                        const li = document.createElement("li");
                        li.textContent = `${kurssi.nimi} (${kurssi.opintopisteet} op)`;
                        ul.appendChild(li);
                    }
                    div.appendChild(ul);
                } else {
                    const noCourses = document.createElement("p");
                    noCourses.textContent = "Ei kursseja";
                    div.appendChild(noCourses);
                }

                resultsContainer.appendChild(div);
            }
        } else {
            console.error("Server error:", data.message);
        }
    } catch (error) {
        console.error("Fetch failed:", error);
    }
});
