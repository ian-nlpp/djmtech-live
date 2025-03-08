document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        const loginEmail = document.getElementById('loginEmail').value.trim();
        const loginPassword = document.getElementById('loginPassword').value.trim();

        if (!validateLoginInputs(loginEmail, loginPassword)) {
            return;
        }

        try {
            const response = await fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: loginEmail, password: loginPassword })
            });

            const result = await response.json();

            if (result.success) {
                alert('Login successful!');
                localStorage.setItem('loggedInUser', JSON.stringify(result.user)); // Store user data
                window.location.href = 'dashboard.html';
            } else {
                showError('loginError', result.errors[0]);
            }
        } catch (error) {
            showError('loginError', 'An error occurred. Please try again.');
            console.error('Login error:', error);
        }
    });
});

// Keep your existing validation and error handling functions
function validateLoginInputs(email, password) {
    let isValid = true;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailPattern.test(email)) {
        showError('loginEmail', 'Please enter a valid email.');
        isValid = false;
    }
    if (!password) {
        showError('loginPassword', 'Password is required.');
        isValid = false;
    }
    return isValid;
}

function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (field) {
        const errorMessage = document.createElement("div");
        errorMessage.classList.add("error-message");
        errorMessage.innerText = message;
        const existingError = field.parentNode.querySelector(".error-message");
        if (existingError) existingError.remove();
        field.parentNode.appendChild(errorMessage);
    } else {
        const errorContainer = document.createElement("div");
        errorContainer.classList.add("error-message");
        errorContainer.innerText = message;
        document.querySelector('form').appendChild(errorContainer);
    }
}

function clearErrors() {
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach((error) => error.remove());
}