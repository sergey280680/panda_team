
function isNameSurveyUsed(nameSurvey) {
    // Get the value the user entered in a field
    const nameSurveyValue = nameSurvey.value.trim();

    // Get data from data attribute
    const existingNameSurveys = document.getElementById('nameSurveys').getAttribute('data-namesurveys');
    var dataArray = Object.values(existingNameSurveys);

    var isValueFound = dataArray.some(function(item) {
        return item.toLowerCase() === nameSurveyValue.toLowerCase();
    });

    const nameSurveyMessage = document.getElementById('nameSurveyMessage');

    if (isValueFound) {
        nameSurveyMessage.textContent = 'Назва "' + nameSurveyValue + '" вже існує';
        nameSurveyMessage.style.color = 'red';
        nameSurvey.focus();
    }else {
        nameSurveyMessage.textContent = '';
    }
}

let questionCount = 0;
const maxAnswers = 5;

function addQuestion() {
    questionCount++;
    const surveyForm = document.getElementById('survey-form');
    const questionDiv = document.createElement('div');
    questionDiv.className = "question";
    questionDiv.style.marginBottom = "30px";
    questionDiv.innerHTML = `
                <h2>Питання ${questionCount}:</h2>
                <label for="question_${questionCount}">Текст питання:</label>
                <input type="text" name="questions[${questionCount}]" id="question_${questionCount}" required>
                <button type="button" onclick="removeQuestion(this)">x</button></br>
                <button type="button" onclick="addAnswer(${questionCount})">Додати варіант відповіді</button>

                <div id="answers_${questionCount}"></div>
            `;
    surveyForm.insertBefore(questionDiv, surveyForm.lastElementChild);
}

function addAnswer(questionNumber) {
    const answersDiv = document.getElementById(`answers_${questionNumber}`);
    const answerCount = answersDiv.childElementCount + 1;
    const answerInput = document.createElement('div');

    if (answerCount <= maxAnswers) {
        answerInput.innerHTML = `
                <input type="text" name="answers[${questionNumber}][${answerCount}]"
                placeholder="Варіант відповіді ${answerCount}" required>
                <button type="button" onclick="removeAnswer(this)">x</button>
            `;
        answersDiv.appendChild(answerInput);
    }else {
        alert('Досягнуто максимальної кількості варіантів відповідей (5)');
    }

}

function removeQuestion(button) {
    const questionDiv = button.parentNode;
    questionDiv.remove();
    updateQuestionNumbers();
}

function removeAnswer(button) {
    const answerInput = button.parentNode;
    answerInput.remove();
}

function updateQuestionNumbers() {
    const questionDivs = document.querySelectorAll('.question');
    questionCount = 0;
    questionDivs.forEach((questionDiv, index) => {
        questionCount++;
        const questionNumberElement = questionDiv.querySelector('h2');
        questionNumberElement.textContent = `Питання ${questionCount}:`;
        const inputs = questionDiv.querySelectorAll('input');
        inputs.forEach((input) => {
            const name = input.getAttribute('name').replace(/\[\d+\]/, `[${questionCount}]`);
            input.setAttribute('name', name);
        });
    });
}

function validateForm() {
    const questionDivs = document.querySelectorAll('.question');

    if (questionDivs.length === 0) {
        alert('Додайте хоча б одне запитання та варіант відповіді.');
        return false; // Остановка отправки формы
    }

    for (let i = 0; i < questionDivs.length; i++) {
        const answersDiv = questionDivs[i].querySelector(`#answers_${i + 1}`);
        const answerInputs = answersDiv.querySelectorAll('input[type="text"]');

        if (answerInputs.length === 0) {
            alert('Додайте хоча б один варіант відповіді до кожного питання.');
            return false; // Зупинка відправлення форми
        }
    }

    return true; // Дозвіл відправлення форми
}