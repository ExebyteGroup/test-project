@extends('layout')
@section('content')
    <div>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($answer as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->questions->question }}</td>
                    <td>{{ $item->answers->answer }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="custom_back_button_box">
            <a href="{{ url('/answers') }}" class="btn btn-primary">
                Back
            </a>
        </div>
    </div>
@endsection
