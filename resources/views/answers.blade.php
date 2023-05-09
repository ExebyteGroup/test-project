@extends('layout')
@section('content')
    <div>
        <table>
            <thead>
            <tr>
                <th>Key</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->key }}</td>
                    <td><a href="{{ url('/answers/'.$item->key) }}"> {{ $item->questions->question }} </a></td>
                    <td>{{ $item->answers->answer }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
