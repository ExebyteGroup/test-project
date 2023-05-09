@extends('layout')
@section('content')

    <div class="container result_container">
        <div class="row">
            <div class="col-md-12">
                <center><h3>Your Result</h3></center>
                <h2 class="title_design_class">{{ $result->name }}</h2>

                <div class="description_design_class">
                    {{ $result->description }}
                </div>
            </div>
        </div>
        <a href="{{ url('/') }}" style="margin: 15px;" class="btn btn-primary">Retake your test</a>
    </div>


@endsection
