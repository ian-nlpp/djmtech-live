document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById("formElement");

    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            clearErrors();

            const firstName = document.getElementById("firstName").value.trim();
            const lastName = document.getElementById("lastName").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const street = document.getElementById("street").value.trim();
            const barangay = document.getElementById("barangay").value.trim();
            const city = document.getElementById("city").value.trim();
            const province = document.getElementById("province").value.trim();
            const zipCode = document.getElementById("zipCode").value.trim(); // Added zipCode
            const password = document.getElementById("password").value.trim();
            const confirmPassword = document.getElementById("confirmPassword").value.trim();

            let hasError = false;
            const errorMessages = [];
            if (firstName === "") { errorMessages.push("First Name is required."); hasError = true; }
            if (lastName === "") { errorMessages.push("Last Name is required."); hasError = true; }
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === "" || !emailPattern.test(email)) { errorMessages.push("Please enter a valid email address."); hasError = true; }
            const phonePattern = /^09\d{9}$/;
            if (phone === "" || !phonePattern.test(phone)) { errorMessages.push("Phone number must start with '09' and be 11 digits long."); hasError = true; }
            if (street === "") { errorMessages.push("Street address is required."); hasError = true; }
            if (barangay === "") { errorMessages.push("Barangay is required."); hasError = true; }
            if (city === "") { errorMessages.push("City is required."); hasError = true; }
            if (province === "") { errorMessages.push("Province is required."); hasError = true; }
            if (zipCode === "" || !/^\d{4}$/.test(zipCode)) { 
                errorMessages.push("Zip code must be a 4-digit number."); 
                hasError = true; 
            }
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (password === "" || !passwordPattern.test(password)) { 
                errorMessages.push("Password must be at least 8 characters, contain an uppercase letter, a number, and a special character."); 
                hasError = true; 
            }
            if (confirmPassword !== password) { errorMessages.push("Passwords do not match."); hasError = true; }

            if (hasError) {
                displayErrors(errorMessages);
                return;
            }

            const formData = new FormData();
            formData.append('firstName', firstName);
            formData.append('lastName', lastName);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('street', street);
            formData.append('barangay', barangay);
            formData.append('city', city);
            formData.append('province', province);
            formData.append('zipCode', zipCode); // Added zipCode
            formData.append('password', password);

            fetch('signup.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message); // Replace with better UI if desired
                    window.location.href = 'login.html';
                } else {
                    displayErrors(data.errors);
                }
            })
            .catch(error => {
                displayErrors(["An error occurred. Please try again."]);
                console.error('Signup error:', error);
            });
        });
    }

    function displayErrors(messages) {
        const errorMessagesDiv = document.getElementById("errorMessages");
        const errorList = document.getElementById("errorList");
        errorList.innerHTML = "";
        messages.forEach(message => {
            const listItem = document.createElement("li");
            listItem.textContent = message;
            errorList.appendChild(listItem);
        });
        errorMessagesDiv.style.display = "block";
    }

    function clearErrors() {
        const errorMessagesDiv = document.getElementById("errorMessages");
        errorMessagesDiv.style.display = "none";
    }
});