const message = document.getElementById("message");
const form = document.getElementById("form_ilmoittautuminen");

form.addEventListener("submit", e => {
    e.preventDefault();
    const formData = new FormData(form);

    fetch("tallenna.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                message.innerHTML = data.message;
                form.reset();
            } else {
                message.innerHTML = data.message || "Ilmoittautuminen epäonnistui.";
            }
        })
        .catch(error => {
            console.error("Error:", error);
            message.innerHTML = "An error occurred while submitting the form.";
        });

    fetchIlmoittautuneet();
});

const ilmoittautuneet = document.getElementById("ilmoittautuneet-lista");

function fetchIlmoittautuneet() {
    fetch("ilmoittautuneet.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                ilmoittautuneet.innerHTML = "";
                if (data.ilmoittautumiset.length > 0) {
                    data.ilmoittautumiset.forEach(item => {
                        const div = document.createElement("div");
                        div.textContent = `${item.etunimi} ${item.sukunimi} (${item.email}) - ${item.kurssi}`;
                        ilmoittautuneet.appendChild(div);
                    });
                } else {
                    ilmoittautuneet.innerHTML = "<p>Ei ilmoittautumisia.</p>";
                }
            }
            else {
                ilmoittautuneet.innerHTML = "<p>Virhe tietojen hakemisessa.</p>";
            }
        })
        .catch(error => {
            console.error("Error fetching ilmoittautuneet:", error);
            ilmoittautuneet.innerHTML = "<p>Virhe tietojen hakemisessa.</p>";
        });
}

fetchIlmoittautuneet();

