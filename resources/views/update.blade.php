@extends('layout')
@section('content')

    <div class="container" style="min-width: 600px;">
        <div class="row">
            <div class="col-md-12">
                <h2>Update a Question</h2>
                <form action="{{ url('question/update/'.$question->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" value="{{ $question->question }}" name="question" id="question" class="form-control" style="width:100%" required>
                    </div>

                    @foreach($question->answers as $key => $answare)
                        <div class="form-group">
                            <label for="answer_{{ $key+1 }}">Answer {{ $key+1 }}</label>
                            <input type="text" value="{{ $answare->answer }}" name="answers[{{ $key+1 }}]" id="answer_{{ $key+1 }}" class="form-control" style="width:100%" required>
                            <select name="result_answer[{{ $key+1 }}]" class="form-control" style="width:100%">
                                @foreach($result_parameters as $item)
                                    <option {{ $item->id == $answare->parameter->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    <div class="answers-container"></div>
                    <button type="button" class="btn btn-primary" id="add-answer">Add Answer</button>
                    <button type="submit" class="btn btn-primary">Update Question</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const addAnswerBtn = document.getElementById('add-answer');
        const answersContainer = document.querySelector('.answers-container');
        let results = {!! json_encode($result_parameters) !!};
        let answerCount = {{ count($question->answers) }};

        addAnswerBtn.addEventListener('click', function() {
            answerCount++;
            const answerDiv = document.createElement('div');
            answerDiv.classList.add('form-group');
            answerDiv.innerHTML = `
            <label for="answer_${answerCount}">Answer ${answerCount}</label>
            <input type="text" name="answers[${answerCount}]" id="answer_${answerCount}" class="form-control" style="width:100%">
               <select name="result_answer[${answerCount}]" class="form-control" style="width:100%">
                    ${results.map(option => {
                return `<option value="${option.id}">${option.name}</option>`;
            }).join('')}
               </select>`;
            answersContainer.appendChild(answerDiv);
        });
    </script>

    <style>
        .container {
            margin-top: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Style the table */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        /* Style the form to look like a table */
        form {
            display: table;
            width: 100%;
        }

        .form-group {
            display: table-row;
        }

        label {
            display: table-cell;
            width: 25%;
            padding: 10px;
        }

        input[type="text"],
        select {
            display: table-cell;
            width: 75%;
        }

        button[type="submit"] {
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .answers-container {
            display: contents;
        }
    </style>

@endsection
