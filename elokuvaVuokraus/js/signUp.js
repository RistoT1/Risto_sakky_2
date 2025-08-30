const form = document.querySelector('form');

const passwordValidation = () => {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
    }
    return true;
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!passwordValidation()) {
        return;
    }
    const formData = new FormData(form);
    try {
        const response = await fetch('./../api/addUser.php', {
            method: 'POST',
            body: formData
        });
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                window.location.href = './logIn.php'; 
            } else {
                alert('Signup failed: ' + data.message);
            }
        } else {
            alert('Network response was not ok.');
        }
    }
    catch (error) {
        console.error('Error:', error);
        alert('There was a problem with the signup request.');
    }

});