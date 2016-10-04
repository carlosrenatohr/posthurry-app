@extends('layouts.main')
@section('others-js')
    {{--    <script src="{{ asset('js/access.js') }}"></script>--}}
    <script src="{{ asset('js/init.js') }}"></script>
@endsection
@section('others-css')
    <style>
        .postNumberTitle {
            font-size: 20px;
            font-weight: 800;
        }
    </style>
@endsection
@section('content')
    {!! Form::open(['url' => route('postData'), 'method' => 'post', 'class' => '', 'enctype' => 'multipart/form-data'])!!}

    <div class="container pricer">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 post_entry">
                <div class="floating-labels">
                    <h4>Choose one of the following</h4>

                    <ul class="cd-form-list list-inline">
                        <li>
                            <label class="radio-inline" for="cd-radio-1">
                                <input type="radio" name="typeToPost" id="cd-radio-1"  value="0" checked>
                                Each Page and Group
                            </label>
                        </li>

                        <li>
                            <label class="radio-inline" for="cd-radio-2">
                                <input type="radio" name="typeToPost" id="cd-radio-2" value="1">
                                Two pages
                            </label>
                        </li>

                        <li>
                            <label class="radio-inline" for="cd-radio-3">
                                <input type="radio" name="typeToPost" id="cd-radio-3" value="2">
                                Two groups
                            </label>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="cd-form floating-labels">
                    <h4>Duration of comparison</h4>
                    <p class="cd-select">
                        <select name="limitDaysDuration">
                            <option value="5">5 Minutes</option>
                            <option value="30">30 Minutes</option>
                            <option value="120">2 Hours</option>
                            <option value="360">6 Hours</option>
                            <option value="720">12 Hours</option>
                            <option value="1440">1 day</option>
                        </select>
                    </p>
                </div>

            </div>
        </div>

        <div class="row post_entry">
            <div class="col-md-6" id="post1-container">
                <div class="pages-list-container">
                    <span class="postNumberTitle">A</span>
                    <h4>Select a Page</h4>
                    <p class="cd-select icon">
                        <select class="budget select-pages" name="post1_page_id" data-control="Page combobox">
                            <option value="">Select Page</option>
                        </select>
                        <input type="hidden" value="1" name="post1_sort" class="page_sort">
                    </p>
                </div>
                <div class="groups-list-container hide">
                    <span class="postNumberTitle">A</span>
                    <h4>Select a Group</h4>
                    <p class="cd-select icon">
                        <select class="budget select-groups" name="post1_page_id" disabled data-control="Group combobox">
                            <option value="">Select Group</option>
                        </select>
                        <input type="hidden" value="2" name="post1_sort" class="group_sort" disabled>
                        <input type="hidden" name="post1_page_name" id="post1_page_name">
                    </p>
                </div>
                <div class="icon">
                    {{--<label class="cd-label" for="cd-textarea">Type your Status</label>--}}
                    {!! Form::textarea('post1_text', null, ['class'=> 'message post-textarea', 'id' => 'cd-textarea-post1', 'required', 'data-control' => 'First Post Status', 'placeholder' => 'Type your Status']) !!}
                </div>

                <div class="form-group">
                    {{ Form::file('post1_image', []) }}
                </div>
            </div>

            <div class="col-md-6" id="post2-container">
                <div class="groups-list-container">
                    <span class="postNumberTitle">B</span>
                    <h4>Select a Group</h4>
                    <p class="cd-select icon">
                        <select class="budget select-groups" name="post2_page_id" required data-control="Group combobox">
                            <option value="">Select Group</option>
                        </select>
                        <input type="hidden" value="2" name="post2_sort" class="group_sort">
                    </p>
                </div>
                <div class="pages-list-container hide">
                    <span class="postNumberTitle">B</span>
                    <h4>Select a Post</h4>
                    <p class="cd-select icon">
                        <select class="budget select-pages" name="post2_page_id" required disabled data-control="Page combobox">
                            <option value="">Select Page</option>
                        </select>
                        <input type="hidden" value="1" name="post2_sort" class="page_sort" disabled>
                        <input type="hidden" name="post2_page_name" id="post2_page_name">
                    </p>
                </div>
                <div class="icon">
                    {{--<label class="cd-label" for="cd-textarea">Type your Status</label>--}}
                    {!! Form::textarea('post2_text', null, ['class'=> 'message post-textarea', 'id' => 'cd-textarea-post2', 'required', 'data-control' => 'Second Post Status', 'placeholder' => "Type your status"]) !!}
                </div>

                <div class="form-group">
                    {{ Form::file('post2_image', []) }}
                </div>
            </div>
        </div>
        <div class="spacer"></div>
        <label class="checkbox-inline" for="blastMassChkbox">
            <input type="checkbox" id="blastMassChkbox" name="blastMassChkbox">
                Do you want to BLAST to multiple Groups and Pages?
        </label>
        <div class="spacer"></div>
        <br>
        <button class="post_submit" id="scheduleBtn" type="button">Press to Schedule post</button>
        <br>
        <div id="blastingTimeContainer" style="display: none;">
            <label for="">When?</label>
            <input type="text" id="blastDateTime" name="blastDatetime" data-field="datetime" readonly disabled>
            <div id="blastDateTimePlugin"></div>
        </div>
    </div>

    <div class="add">
        <h1 class="text-center">Add UP TO 25 Groups OR Pages</h1>
        <h5 class="text-center blasting-title-container" data-count="0">
            Your selection: <b>00</b>
        </h5>
        <div class="container below-container">
            <div class="row cd-form">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="margin:0;">
                            <h3 class="panel-title">Groups</h3>
                        </div>
                        <div class="panel-body groups blasting-form" style="max-height:400px;overflow-y: scroll;margin:0 auto;">
                            <div class="alert alert-warning">
                                <b>Selected:</b>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="margin:0;">
                            <h3 class="panel-title">Pages</h3>
                        </div>
                        <div class="panel-body pages blasting-form" style="max-height:400px;overflow-y: scroll;margin:0 auto;">
                            <div class="alert alert-warning">
                                <b>Selected:</b>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="pagesNamesSelected" id="pagesNamesSelected">
            <input type="hidden" name="groupsNamesSelected" id="groupsNamesSelected">
            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
            <button type="submit" class="post_submit submit-btn" id="createContestSubmitBtn">
                Submit your post
            </button>
        </div>
    </div>
    {{ Form::close() }}
@endsection