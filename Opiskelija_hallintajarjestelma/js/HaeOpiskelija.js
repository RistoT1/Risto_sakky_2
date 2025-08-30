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

    const response = await fetch(`../api/HaeOpiskelijaFetch.php?${queryString}`);
    const data = await response.json();
    if(!response.ok) {
        console.error("Error fetching data:", data);
    }
    if(data.status === "success") {
        console.log("Fetched data:", data);
    }
});

