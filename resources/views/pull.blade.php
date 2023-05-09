@extends('layout')
@section('content')
    <div class="container">

        <form class="poll-form" id="answerForm" action="{{ url('answers/store') }}" method="POST">
            @csrf
            <div id="counter"></div>
            <input type="hidden" name="current_question" id="current_question" value="0">
            <div id="question_container">
                <h4 id="question_text"></h4>
                <ul id="answer_list">
                </ul>
            </div>
            <input type="hidden" name="items" id="items" />

            <button type="submit" id="submit_button">
                Submit
            </button>
            <button type="button" id="next_button">
                Next
            </button>
        </form>
    </div>

    <script>
        // Get the questions JSON object from the server and convert it to a JavaScript object
        let questions = {!! $questions->toJson() !!};

        // Initialize the current question index to 0 and the answers array to an empty array
        let currentQuestion = 0;
        let answers = [];

        // Get the answer form element from the HTML document
        let form_el = document.getElementById("answerForm");

        // This function displays the current question and its answer options on the webpage
        function showQuestion(question) {
            let questionText = document.getElementById('question_text');
            let answerList = document.getElementById('answer_list');
            let submitButton = document.getElementById('submit_button');
            let nextButton = document.getElementById('next_button');

            // Update question text
            questionText.innerHTML = question.question;

            // Clear answer list
            answerList.innerHTML = '';

            // Add answer options to list
            for (let i = 0; i < question.answers.length; i++) {
                let answer = question.answers[i];
                let li = document.createElement('li');
                let label = document.createElement('label');
                let radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'answer_' + question.id;
                radio.value = answer.answer;
                label.appendChild(radio);
                label.appendChild(document.createTextNode(answer.answer));
                li.appendChild(label);
                answerList.appendChild(li);
            }

            let counter = document.getElementById('counter');
            counter.innerHTML = currentQuestion + 1 +'/'+questions.length;

            // Hide submit button if this is not the last question
            if (currentQuestion < questions.length - 1) {
                submitButton.style.display = 'none';
                nextButton.style.display = 'block';
            } else {
                submitButton.style.display = 'block';
                nextButton.style.display = 'none';
            }
        }

        // This function is called when the "Next" button is clicked
        function getNextQuestion() {
            currentQuestion++;
            if (currentQuestion >= questions.length) {
                // End of questions
                document.getElementById('question_container').style.display = 'none';
            } else {
                // Display the next question
                showQuestion(questions[currentQuestion]);
                // Set the value of the hidden input field to the current question index
                document.getElementById('current_question').value = currentQuestion;
            }
        }

        // Show the first question when the page loads
        showQuestion(questions[currentQuestion]);

        // Add a click event listener to the "Next" button
        document.getElementById('next_button').addEventListener('click', function() {
            // Get the selected answer for the current question
            if (setAnswers()[0]) {
                // If an answer is selected, go to the next question
                getNextQuestion();
            } else {
                // If no answer is selected, display an alert message
                alert('Please select an answer.');
            }
        });

        // Add a submit event listener to the answer form
        form_el.addEventListener("submit", function(evt) {
            // Set the selected answers in the hidden input field as a JSON object
            setAnswers();
            document.getElementById('items').value = JSON.stringify(answers);
        });

        // This function gets the selected answer for the current question and stores it in the answers array
        function setAnswers() {
            // Get the answer options for the current question
            let answerInputs = document.getElementsByName('answer_' + questions[currentQuestion].id);
            let selectedAnswer = null;

            // Loop through the answer options and find the selected answer
            for (let i = 0; i < answerInputs.length; i++) {
                if (answerInputs[i].checked) {
                    // Store the selected answer in the answers array
                    selectedAnswer = questions[currentQuestion].answers.filter(obj => {
                        return obj.answer === answerInputs[i].value;
                    });
                    answers = answers.filter(object => {
                        return object.question_id !== selectedAnswer[0].question_id;
                    });
                    answers.push({"question_id": selectedAnswer[0].question_id, "answer_id": selectedAnswer[0].id});
                    break;
                }
            }
            return selectedAnswer;
        }
    </script>
@stop
