@extends('layouts.main')
@section('content')
    <div class="row-fluid">
        <h1>List of comparison You generate</h1>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Post 1 in</th>
                    <th>Post 2 in</th>
                    <th>Created at</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->comparisons as $comparison)
                    <tr>
                        <td><a href="{{ url('comparison/'. $comparison->id) }}">Link</a></td>
                        <td>{{ $comparison->post1_page_id }}</td>
                        <td>{{ $comparison->post2_page_id }}</td>
                        <td>{{ $comparison->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-warning btn-lg pull-right">Back</a>
    </div>
@endsection