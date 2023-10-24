function validateForm() {
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    let isAtLeastOneChecked = false;

    for (let radioButton of radioButtons) {
        if (radioButton.checked) {
            isAtLeastOneChecked = true;
            break;
        }
    }

    if (!isAtLeastOneChecked) {
        alert("Будь ласка, дайте відповідь на всі запитання.");
        return false; // Stopping form submission
    }

    return true; // Allow form submission
}