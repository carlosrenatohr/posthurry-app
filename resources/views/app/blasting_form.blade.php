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
    <div class="col-md-12" style="height:74%;margin-bottom:4%;margin-top:4%;">

        <div class="col-md-12" id="post-container-blastingForm">
            <fieldset class="cd-form floating-labels">
                <div>
                    <h4>Post you want to create</h4>
                </div>

                <div class="icon">
                    <label class="cd-label" for="cd-textarea">Type your Status</label>
                    {!! Form::textarea('post1_text', null, ['class'=> 'message post-textarea', 'id' => 'cd-textarea-post1', 'required', 'data-control' => 'First Post Status']) !!}
                </div>
                <div class="">
                    <div class="form-group">
                        {{ Form::file('post1_image', []) }}
                    </div>
                </div>

            </fieldset>
        </div>
        <div class="col-md-12">
            <div class="cd-form" style="max-width: 100%;">

                <div class="blasting-title-container">
                    Add up to 25 Groups or Pages. Your selection: <b>0</b>
                </div>
                <div class="below-container">
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
                    <input type="hidden" name="pagesNamesSelected" id="pagesNamesSelected">
                    <input type="hidden" name="groupsNamesSelected" id="groupsNamesSelected">
                </div>
                <div>
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <input type="submit" value="Submit" style="margin: 10px 0;" class="submit-btn"
                           id="blastingOutSubmitBtn">
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
@endsection