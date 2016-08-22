@extends('layouts.main')
@section('others-js')
    <script src="{{ asset('js/init.js') }}"></script>
@endsection
@section('others-css')
    <style>
        .below-container div :not(.cd-form) {
            margin: 0 !important;
        }

        .below-container .disabled-on {
            /*background-color: rgba(204,204,204, 0.65);*/
            cursor: not-allowed !important;
        }

        /* datetime picker custom styles*/
        #blastDateTimePlugin div {
            margin: 5px auto !important;
        }

        .dtpicker-content {
            padding: 0 !important;
        }

        .dtpicker-overlay {
            background: rgba(0, 0, 0, 0) !important;
        }

        .dtpicker-subcontent {
            border: solid 2px #2b3e51 !important;
            padding: 3px !important;
        }

        .dtpicker-buttonCont .dtpicker-button {
            background: #2b4170;
        }
    </style>
@endsection
@section('content')
    {!! Form::open(['url' => route('postBlasting'), 'method' => 'post', 'class' => '', 'enctype' => 'multipart/form-data'])!!}
    <div class="container pricer">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 post_entry" id="post-container-blastingForm">
                <h4>Enter your Post</h4>

                <div class="icon">
                    {!! Form::textarea('post1_text', null, ['class'=> 'message post-textarea', 'id' => 'cd-textarea-post1', 'required', 'data-control' => 'Post field', 'placeholder' => 'type your status']) !!}
                </div>
                <div class="form-group">
                    {{ Form::file('post1_image', []) }}
                </div>
            </div>
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
                        <div class="panel-heading">
                            <h3 class="panel-title">Groups</h3>
                        </div>
                        <div class="panel-body groups blasting-form" style="max-height:400px;overflow-y: scroll;">
                            <div class="alert alert-warning">
                                <b>Selected:</b>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Pages</h3>
                        </div>
                        <div class="panel-body pages blasting-form" style="max-height:400px;overflow-y: scroll;">
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

            <button type="submit" class="post_submit submit-btn"
                    id="blastingOutSubmitBtn">Submit your post</button>
        </div>
    </div>

    {{ Form::close() }}

@endsection