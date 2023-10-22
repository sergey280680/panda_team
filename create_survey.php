<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
include 'head.php';
?>
<body>
<h1>Створити нове опитування</h1>

<a class='nav-link' href='profile.php' >Назад</a>
<span id="nameSurveyMessage"></span>
<form action="vendor/save_response.php" method="post" id="survey-form">
    <input type="text" name="name_survey" placeholder="Назва опитування" required onblur="isNameSurveyUsed(this)">
    <button type="button" onclick="addQuestion()">Додати питання</button>
    <input class="btn_create_survey" type="submit" value="Створити опитування">
</form>

<script>
    function isNameSurveyUsed(nameSurvey) {
        // Получите значение, которое пользователь ввел в поле "Назва опитування"
        const nameSurveyValue = nameSurvey.value.trim();

        // Получите существующие имена опросов из PHP
        const existingNameSurveys = <?= json_encode($_SESSION['user']['name_surveys']) ?>;
        var dataArray = Object.values(existingNameSurveys);

        var isValueFound = dataArray.some(function(item) {
            return item.toLowerCase() === nameSurveyValue.toLowerCase();
        });

        const nameSurveyMessage = document.getElementById('nameSurveyMessage');

        if (isValueFound) {
            nameSurveyMessage.textContent = 'Название "' + nameSurveyValue + '" уже существует';
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
</body>
</html>