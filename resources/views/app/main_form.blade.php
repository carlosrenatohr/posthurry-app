@extends('layouts.main')
@section('others-js')
    <script src="{{ asset('js/access.js') }}"></script>
@endsection
@section('content')
    {{--<div class="row-fluid">--}}
        {!! Form::open(['url' => route('postData'), 'method' => 'post', 'class' => '', 'enctype' => 'multipart/form-data'])!!}
        <div class="col-md-12" style="height:74%;margin-bottom:4%;margin-top:4%;">
            <div class="cd-form floating-labels">
                <h4>Choose one of the following</h4>

                <ul class="cd-form-list">
                    <li>
                        <input type="radio" name="typeToPost" id="cd-radio-1" value="0" checked>
                        <label  for="cd-radio-1">Each Group and Page</label>
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
            <div class="col-md-6" id="post1-container">
                    <fieldset class="cd-form floating-labels">

                        <div>
                            <div class="pages-list-container">
                                <h4>Select a Page from List</h4>
                                <p class="cd-select icon">
                                    <select class="budget select-pages" name="post1_page_id">
                                        <option value="">Select Page</option>
                                    </select>
                                    <input type="hidden" value="1" name="post1_sort">
                                </p>
                            </div>
                            <div class="groups-list-container hide">
                                <h4>Select a Group from List</h4>
                                <p class="cd-select icon">
                                    <select class="budget select-groups" name="post1_page_id" disabled>
                                        <option value="">Select Group</option>
                                    </select>
                                    <input type="hidden" value="2" name="post1_sort">
                                    <input type="hidden" name="post1_page_name" id="post1_page_name">
                                </p>
                            </div>
                        </div>

                        <div class="icon">
                            <label class="cd-label" for="cd-textarea">Type a Post you Need</label>
                            {!! Form::textarea('post1_text', null, ['class'=> 'message', 'id' => 'cd-textarea', 'required']) !!}
                        </div>

                    </fieldset>
            </div>
            <div class="col-md-6" id="post2-container">
                <fieldset class="cd-form floating-labels">

                    <div>
                        <div class="groups-list-container">
                            <h4>Select a Group from List</h4>

                            <p class="cd-select icon">
                                <select class="budget select-groups" name="post2_page_id" required>
                                    <option value="">Select Group</option>
                                </select>
                                <input type="hidden" value="2" name="post2_sort">
                            </p>
                        </div>
                        <div class="pages-list-container hide">
                            <h4>Select a Page from List</h4>
                            <p class="cd-select icon">
                                <select class="budget select-pages" name="post2_page_id" required disabled>
                                    <option value="">Select Page</option>
                                </select>
                                <input type="hidden" value="1" name="post2_sort">
                                <input type="hidden" name="post2_page_name" id="post2_page_name">
                            </p>
                        </div>
                    </div>

                    <div class="icon">
                        <label class="cd-label" for="cd-textarea">Type a Post you Need</label>
                        {!! Form::textarea('post2_text', null, ['class'=> 'message', 'id' => 'cd-textarea', 'required']) !!}
                    </div>

                    <div>
                        <input type="submit" value="Submit" style="margin: 10px 0;">
                    </div>
                </fieldset>
            </div>
        </div>
    {{--</div>--}}

    {{ Form::close() }}
@endsection