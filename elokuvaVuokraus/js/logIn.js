const form = document.querySelector('form');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    try {
        const response = await fetch('./../api/logCheck.php', {
            method: 'POST',
            body: formData
        });
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                window.location.href = './../pages/dashboard.php'; 
            } else {
                alert('Login failed: ' + data.message);
            }
        } else {
            alert('Network response was not ok.');
        }
    }
    catch (error) {
        console.error('Error:', error);
        alert('There was a problem with the login request.');
    }

});
