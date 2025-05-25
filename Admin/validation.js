// Function to validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to validate user form data
function validateUserForm() {
    const userName = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (userName === '') {
        alert("Username is required.");
        return false;
    }

    if (!isValidEmail(email)) {
        alert("Invalid email format.");
        return false;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

    return true;
}

// Event listener for form submission
document.getElementById('admin-form').addEventListener('submit', function(event) {
    if (!validateUserForm()) {
        event.preventDefault();
    }
});