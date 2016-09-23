@extends('layouts.main')
@section('others-css')
    <style>
        .blastTimeTitle {
            padding: 12px 0;
            font-size: 18px;
            font-weight: 800;
        }
    </style>
@endsection
@section('content')
    <?php $blastAt = (!is_null($comparison->massPosts)) ? new \Carbon\Carbon($comparison->massPosts->blastAt) : null;?>
    <section class="heading">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-xs-6">
                    <h3>A/B History
                        <small style="font-weight:bold; color:#2ac6ec">By {{$comparison->user->name}}</small>
                    </h3>
                </div>
                <div class="col-sm-2 col-xs-3">
                    <a href="{{ redirect()->getUrlGenerator()->previous() }}"
                       class="btn-warning pull-right">Back</a>
                </div>
                <div class="col-sm-2 col-xs-3">
                    @if(!is_null($comparison->massPosts))
                        <a href="javascript:void(0);" class="btn-warning pull-left" data-toggle="modal" data-target="#massPagesListModal">Mass Groups</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <h2 class="" style="font-size: 18px;"
                >@if($isExpired)
                        Comparison is expired!
                        @if(!is_null($comparison->winner))Winner was {{ $comparison->{'post'. $comparison->winner .'_page_name'} }} @endif
                    @else
                        <?php $resting = ($comparison->limitDaysDuration > 60) ? round($comparison->limitDaysDuration / 60, 2) : $comparison->limitDaysDuration;?>
                        Comparison during {{  $resting }} {{ ($comparison->limitDaysDuration < 60) ? 'minutes' : 'hours' }}
                        from {{ date('M d, Y', strtotime($comparison->created_at)) }} at {{ date('h:i A', strtotime($comparison->created_at)) }}
                    @endif
                </h2>
                @if(!is_null($comparison->massPosts))
                    <p class="blastTimeTitle">
                        @if(is_null($comparison->massPosts->posts_published))
                            will blast out at {{ $blastAt->format('d-m-Y h:iA') }}
                        @else
                            Blasted Out!
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>

        <div class="col-md-6 col-xs-12">
            <div class="panel panel-success">
                <div class="panel-heading"> Posted on {{$comparison->post1_page_name }}</div>
                <div class="panel-body">
                    <p>{{$comparison->post1_text }}</p>
                    <a href="https://fb.com/{{ $comparison->post1_post_id }}" target="_blank" class="btn btn-info" style="background-color: #3B5998;margin: 5px 0;">See on facebook</a>
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
                    <a href="https://fb.com/{{ $comparison->post2_post_id }}" target="_blank" class="btn btn-info" style="background-color: #3B5998;margin: 5px 0;">See on facebook</a>
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
    <div class="row">
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
                    <h4 class="modal-title" id="massPagesListModalLabel">Pages / Groups Linked</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="blastTimeTitle">
                                @if(is_null($comparison->massPosts->posts_published))
                                    Will blast out at {{ $blastAt->format('d-m-Y h:iA') }}
                                @else
                                    Blasted Out! ({{ $blastAt->format('m-d-Y h:iA') }})
                                @endif
                            </h4>
                            <p>Press the page link to check your post.</p>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-info" >
                                <div class="panel-heading">
                                    <h3 class="panel-title">Groups</h3>
                                </div>
                                <div class="panel-body">
                                    <div style="max-height:400px;overflow-y: scroll;">
                                        <ul class="list-group">
                                            <?php
                                                $groups_names = $comparison->groups;
                                                $published = $comparison->published;
                                            ?>
                                            @if(!empty($groups_names[0]))
                                            @foreach($groups_names as $index => $group)
                                                <li class="list-group-item">
                                                    <span class="badge"><i class="fa fa-{{ (!is_null($comparison->winner) ? 'check' : 'asterisk') }}"></i></span>
                                                    @if(is_null($comparison->massPosts->posts_published))
                                                    {{ $group }}
                                                    @else
                                                        <?php ?>
                                                        <a href="https://fb.com/{{$published[$index]}}" target="_blank">{{ $group }}</a>
                                                    @endif
                                                </li>
                                            @endforeach
                                            @endif
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
                                            <?php $pages_names = $comparison->pages;

                                            ?>
                                            @if(!empty($pages_names[0]))
                                                @foreach($pages_names as $index => $page)
                                                <li class="list-group-item">
                                                    <span class="badge"><i class="fa fa-{{ (!is_null($comparison->winner) ? 'check' : 'asterisk') }}"></i></span>
                                                    @if(is_null($comparison->massPosts->posts_published))
                                                        {{ $page }}
                                                    @else
                                                        <a href="https://fb.com/{{$published[$index + count($groups_names)]}}" target="_blank">{{ $page }}</a>
                                                    @endif
                                                </li>
                                                @endforeach
                                            @endif
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
