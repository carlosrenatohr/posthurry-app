@extends('layouts.main')
@section('content')
    <div class="row-fluid">
        <div class="col-md-12">
            <h1 class="pull-left" style="font-size: 30px;padding: 30px 10px;">
                Comparison
                <small>Created by: {{ $comparison->user->name }}</small>
            </h1>
            <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-warning btn-lg pull-right" style="margin: 15px;">Back</a>
        </div>
        <div class="col-md-12">
            <div class="alert alert-warning">
            <h2 class="" style="font-size: 18px;">
                @if($isExpired)
                    Comparison is expired!<br>
                    Winner was {{ $comparison->{'post'. $comparison->winner .'_page_name'} }}
                @else
                    Comparison during {{  $comparison->limitDaysDuration }} days from {{ date('M d, Y', strtotime($comparison->created_at)) }}
                @endif
            </h2>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="panel panel-success">
                <div class="panel-heading"> Posted on {{$comparison->post1_page_name }}</div>
                <div class="panel-body">
                    <p>{{$comparison->post1_text }}</p>
                    <div class="divider-img-post"></div>
                    @if(!is_null($comparison->post1_img_url))
                    <div class="img-container-post">
                        <img src="{{ $comparison->post1_img_url }}">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="panel panel-danger">
                <div class="panel-heading"> Posted on {{$comparison->post2_page_name }}</div>
                <div class="panel-body">
                    <p>{{ $comparison->post2_text }}</p>
                    <div class="divider-img-post"></div>
                    @if(!is_null($comparison->post2_img_url))
                        <div class="img-container-post">
                            <img src="{{ $comparison->post2_img_url }}">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{ Form::hidden('id', $comparison->id, ['id' => 'comparison_id']) }}
    </div>
    <div class="row-fluid">
        <div class="col-md-12 col-xs-12">
            <div id="comparison-chart-container">
                <p>Graph is generating . . .</p>
            </div>
        </div>
    </div>
@endsection