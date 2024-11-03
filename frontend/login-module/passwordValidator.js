document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm-password');
    const message = document.getElementById('password-message');

    passwordField.addEventListener('input', validatePassword);
    confirmPasswordField.addEventListener('input', validatePassword);

    function validatePassword() {
        const password = passwordField.value;

        const minLength = 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /[0-9]/.test(password);
        const hasSymbols = /[!@#$%^&*(),-_.?":{}|<>;"']/.test(password);

        // Clear previous messages
        message.innerText = "";

        if (password.length < minLength) {
            message.innerText = "Password must be at least 8 characters long.";
            message.style.color = 'red';
            return false;
        }
        if (password.length > 20) {
            message.innerText = "Password must be at less 20 characters";
            message.style.color = 'red';
            return false;
        }
        if (!hasUpperCase) {
            message.innerText = "Password must contain at least one uppercase letter.";
            message.style.color = 'red';
            return false;
        }
        if (!hasLowerCase) {
            message.innerText = "Password must contain at least one lowercase letter.";
            message.style.color = 'red';
            return false;
        }
        if (!hasNumbers) {
            message.innerText = "Password must contain at least one number.";
            message.style.color = 'red';
            return false;
        }
        if (!hasSymbols) {
            message.innerText = "Password must contain at least one special character.";
            message.style.color = 'red';
            return false;
        }

        message.innerText = "Password is strong.";
        message.style.color = 'green';
        return true; // Valid password
    }
});
