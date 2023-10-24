function submitForm() {
    // Get all selected checkboxes
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const data = {};

    checkboxes.forEach(checkbox => {
        data[checkbox.name] = checkbox.checked ? 1 : 0;
    });

    // Create a hidden field to submit data
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'status_update';
    hiddenField.value = JSON.stringify(data);

    // Add a hidden field to a form
    const form = document.getElementById('status-update-form');
    form.appendChild(hiddenField);

    form.submit();
}