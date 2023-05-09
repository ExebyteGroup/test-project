@extends('layout')
@section('content')
<div class="container ">
    <div class="row result_parameter_table_class table_result_parameter">
        <div class="col-md-12">
            <h2>Create a result parameter</h2>
            <form action="{{ url('result-parameter/store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" style="width:100%" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea rows="5" name="description" id="description" class="form-control" style="width:100%" required></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Parameter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
