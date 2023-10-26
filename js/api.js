// Link to JSON file
const jsonUrl = '../data.json';

// Element in which data will be displayed
const jsonContainer = document.getElementById('json-container');
// Function to load and display JSON
function loadAndDisplayJSON() {
    fetch(jsonUrl)
        .then(response => response.json())
        .then(data => {
            // Converting JSON data to a readable, indented string
            const prettyJSON = JSON.stringify(data, null, 2);

            // Inserting data into an element on a page
            jsonContainer.textContent = prettyJSON;
        })
        .catch(error => {
            console.error('Ошибка загрузки JSON:', error);
            jsonContainer.textContent = 'Ошибка загрузки JSON';
        });
}

// Run a function on page load
window.addEventListener('load', loadAndDisplayJSON);
