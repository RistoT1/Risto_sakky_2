const buttons = document.querySelectorAll(".haeBtn");
const label = document.getElementById("formLabel");
const input = document.getElementById("inputField");

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
