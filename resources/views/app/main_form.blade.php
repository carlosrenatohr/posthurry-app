@extends('layouts.main')
@section('others-js')
    <script src="{{ asset('js/access.js') }}"></script>
@endsection
@section('content')
    {{--<div class="row-fluid">--}}
    <? //format('Y-m-d H:i:s')); ?>
        {!! Form::open(['url' => route('postData'), 'method' => 'post', 'class' => '', 'enctype' => 'multipart/form-data'])!!}
        <div class="col-md-12" style="height:74%;margin-bottom:4%;margin-top:4%;">
            <div class="cd-form floating-labels">
                <h4>Choose one of the following</h4>

                <ul class="cd-form-list">
                    <li>
                        <input type="radio" name="typeToPost" id="cd-radio-1" value="0" checked>
                        <label  for="cd-radio-1">Each Page and Group</label>
                    </li>

                    <li>
                        <input type="radio" name="typeToPost" id="cd-radio-2" value="1">
                        <label for="cd-radio-2">Two Pages</label>
                    </li>

                    <li>
                        <input type="radio" name="typeToPost" id="cd-radio-3" value="2">
                        <label for="cd-radio-3">Two Groups</label>
                    </li>
                </ul>
            </div>
            <div class="cd-form floating-labels">
                <h4>Duration of comparison</h4>
                <p class="cd-select">
                    <select name="limitDaysDuration">
                        {{--@for($num = 1;$num<=5;$num++)--}}
                        {{--<option value="{{ $num }}">{{ $num }}</option>--}}
                        {{--@endfor--}}
                        <option value="5">5 Minutes</option>
                        <option value="30">30 Minutes</option>
                        <option value="120">2 Hours</option>
                        <option value="360">6 Hours</option>
                        <option value="720">12 Hours</option>
                        <option value="1440">1 day</option>
                    </select>
                </p>
                {{--<input type="number" name="limitDaysDuration" id="" min="0" step="1" max="5" value="5">--}}
            </div>
            <div class="col-md-6" id="post1-container">
                    <fieldset class="cd-form floating-labels">

                        <div>
                            <div class="pages-list-container">
                                <h4>Select a Post</h4>
                                <p class="cd-select icon">
                                    <select class="budget select-pages" name="post1_page_id">
                                        <option value="">Select Page</option>
                                    </select>
                                    <input type="hidden" value="1" name="post1_sort" class="page_sort">
                                </p>
                            </div>
                            <div class="groups-list-container hide">
                                <h4>Select a Group</h4>
                                <p class="cd-select icon">
                                    <select class="budget select-groups" name="post1_page_id" disabled>
                                        <option value="">Select Group</option>
                                    </select>
                                    <input type="hidden" value="2" name="post1_sort" class="group_sort" disabled>
                                    <input type="hidden" name="post1_page_name" id="post1_page_name">
                                </p>
                            </div>
                            <div class="form-group">
                                {{ Form::file('post1_image', []) }}
                            </div>
                        </div>

                        <div class="icon">
                            <label class="cd-label" for="cd-textarea">Type your Status</label>
                            {!! Form::textarea('post1_text', null, ['class'=> 'message', 'id' => 'cd-textarea', 'required']) !!}
                        </div>

                    </fieldset>
            </div>
            <div class="col-md-6" id="post2-container">
                <fieldset class="cd-form floating-labels">

                    <div>
                        <div class="groups-list-container">
                            <h4>Select a Group</h4>

                            <p class="cd-select icon">
                                <select class="budget select-groups" name="post2_page_id" required>
                                    <option value="">Select Group</option>
                                </select>
                                <input type="hidden" value="2" name="post2_sort" class="group_sort">
                            </p>
                        </div>
                        <div class="pages-list-container hide">
                            <h4>Select a Post</h4>
                            <p class="cd-select icon">
                                <select class="budget select-pages" name="post2_page_id" required disabled>
                                    <option value="">Select Page</option>
                                </select>
                                <input type="hidden" value="1" name="post2_sort" class="page_sort" disabled>
                                <input type="hidden" name="post2_page_name" id="post2_page_name">
                            </p>
                        </div>
                        <div class="form-group">
                            {{ Form::file('post2_image', []) }}
                        </div>
                    </div>

                    <div class="icon">
                        <label class="cd-label" for="cd-textarea">Type your Status</label>
                        {!! Form::textarea('post2_text', null, ['class'=> 'message', 'id' => 'cd-textarea', 'required']) !!}
                    </div>

                </fieldset>
            </div>
            <div class="col-md-12">
                <div class="cd-form" style="max-width: 100%;">

                <div class="">
                    <div class="cd-form" style="margin: 0!important;">
                        <div>
                            <input type="checkbox" id="blastMassChkbox" name="blastMassChkbox">
                            <label for="blastMassChkbox">Do you want to blast out in mass groups?</label>
                        </div>
                        <div>
                            <label for="">When?</label>
                            <input type="date" id="blastDate" name="" disabled>
                            <input type="time" id="blastTime" name="" disabled>
                        </div>
                    </div>
                    <div class="cd-form" style="margin: 0!important;">

                    </div>
                    Add up to 25 Groups or Pages
                </div>
                    <style>
                        .below-container div :not(.cd-form){
                            margin: 0!important;
                        }
                        .below-container .disabled-on
                        {
                            /*background-color: rgba(204,204,204, 0.65);*/
                            cursor: not-allowed!important;
                        }
                    </style>
                <div class="below-container">
                    <div class="col-md-6">
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title">Groups</h3>
                            </div>
                            <div class="panel-body groups" style="max-height:400px;overflow-y: scroll;">
                                <div class="alert alert-warning">
                                    <b>Selected:</b>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title">Pages</h3>
                            </div>
                            <div class="panel-body pages" style="max-height:400px;overflow-y: scroll;">
                                <div class="alert alert-warning">
                                    <b>Selected:</b>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="pagesNamesSelected" id="pagesNamesSelected">
                    <input type="hidden" name="groupsNamesSelected" id="groupsNamesSelected">
                    <input type="hidden" name="blastDatetime" id="blastTimeInput">
                </div>
                <div>
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <input type="submit" value="Submit" style="margin: 10px 0;" class="submit-btn">
                </div>
                </div>
            {{--</div>--}}
        </div>
    </div>

    {{ Form::close() }}
@endsection