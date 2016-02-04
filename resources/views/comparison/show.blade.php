@extends('layouts.main')
@section('content')
    <h1>Comparison <small>Created by: {{ $comparison->user->name }}</small></h1>
    <div class="row-fluid">
    <div id="comparison-chart-container"></div>
    {{ Form::hidden('id', $comparison->id, ['id' => 'comparison_id']) }}

    <div class="col-md-12">
        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-warning btn-lg pull-right">Back</a>
    </div>
    </div>
@endsection