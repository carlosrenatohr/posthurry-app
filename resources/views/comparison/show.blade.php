@extends('layouts.main')
@section('content')
    <div class="row-fluid">
        <div class="col-md-12">
            <h1 class="pull-left" style="font-size: 30px;padding: 30px 10px;">
                Comparison
                <small>Created by: {{ $comparison->user->name }}</small>
            </h1>
            <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-warning btn-lg pull-right" style="margin: 15px;">Back</a>
            @if(!is_null($comparison->massPosts))
                <a href="#" class="btn btn-info btn-lg pull-right" style="margin: 15px;" data-toggle="modal" data-target="#massPagesListModal">Mass Groups</a>
            @endif
        </div>
        <div class="col-md-12">
            <div class="alert alert-warning">
            <h2 class="" style="font-size: 18px;">
                @if($isExpired)
                    Comparison is expired!<br>
                    @if(!is_null($comparison->winner))Winner was {{ $comparison->{'post'. $comparison->winner .'_page_name'} }} @endif
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
    {{-- MODAL MASS GROUPS --}}
    @if(!is_null($comparison->massPosts))
    <div class="modal fade" id="massPagesListModal" tabindex="-1" role="dialog" aria-labelledby="massPagesListModalLabel">
        <div class="modal-dialog modal-lg modal-info" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="massPagesListModalLabel">Groups/Pages selected to post in mass</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info" >
                                <div class="panel-heading">
                                    <h3 class="panel-title">Groups</h3>
                                </div>
                                <div class="panel-body">
                                    <div style="max-height:400px;overflow-y: scroll;">
                                        <ul class="list-group">
                                            <?php $groups = explode(',', $comparison->massPosts->groups_names); ?>
                                            @foreach($groups as $group)
                                                <li class="list-group-item">
                                                    <span class="badge"><i class="fa fa-{{ (!is_null($comparison->winner) ? 'check' : 'asterisk') }}"></i></span>
                                                    {{ $group }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-info" >
                                <div class="panel-heading">
                                    <h3 class="panel-title">Pages</h3>
                                </div>
                                <div class="panel-body">
                                    <div style="max-height:400px;overflow-y: scroll;">
                                        <ul class="list-group">
                                            <?php $pages = explode(',', $comparison->massPosts->pages_names); ?>
                                            @foreach($pages as $page)
                                                <li class="list-group-item">
                                                    <span class="badge"><i class="fa fa-{{ (!is_null($comparison->winner) ? 'check' : 'asterisk') }}"></i></span>
                                                    {{ $page }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection