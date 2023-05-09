@extends('layout')
@section('content')
    <div class="table_section">
        <table class="table">
            <thead>
            <tr>
                <th>Questions</th>
                <th style="float: right; margin-right: 45px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allQuestions as $question)
                <tr>
                    <td>
                        <a href="#" class="expand-details" onclick="toggleDetails(event)">{{ $question->question }}</a>
                        <div class="details">
                            @foreach($question->answers as $answers)
                                <p><strong>Offered Answer: </strong> {{ $answers->answer }}</p>
                            @endforeach
                        </div>
                    </td>
                    <td style="float: right;display: flex;">
                        <a href="{{ url("/question/updateOut/$question->id") }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ url("question/delete/$question->id") }}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="/question/add" class="btn btn-primary add_class">Add question</a>
    </div>

    <script>
        function toggleDetails(event) {
            event.preventDefault();
            var detailsDiv = event.target.nextElementSibling;
            if (detailsDiv.style.display === "block") {
                detailsDiv.style.display = "none";
            } else {
                detailsDiv.style.display = "block";
            }
        }
    </script>
@stop
