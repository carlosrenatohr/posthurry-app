@extends('layouts.main')
@section('content')
    <div class="row-fluid">
        <h1 id="fb-welcome">Hurry post</h1>

        {!! Form::open(['url' => route('postData'), 'method' => 'post', 'class' => 'form-horizontal'])!!}
        <div class="col-md-12">
            <p>Select where You post</p>

            <div class="col-md-4">
                <div class="radio">
                    <label>
                        <input type="radio" value="0" name="typeToPost" checked>
                        Each group and page
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="radio">
                    <label>
                        <input type="radio" value="1" name="typeToPost">
                        Two pages
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="radio">
                    <label>
                        <input type="radio" value="2" name="typeToPost">
                        Two Groups
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-md-6 col-sm-6 col-xs-12" id="post1-container">
            <div class="form-group">
                <div class="pages-list-container">
                    <label for="">Select a page from the list</label><br>
                    <select name="post1_page_id" id="" class="form-control select2 select-pages">
                        <option value="">Select a page..</option>
                    </select>
                    <input type="hidden" value="1" name="post1_sort">
                </div>
                <div class="groups-list-container hide">
                    <label for="">Select a group from the list</label><br>
                    <select name="post1_page_id" id="" class="form-control select2 select-groups" disabled>
                        <option value="">Select a group..</option>
                    </select>
                    <input type="hidden" value="2" name="post1_sort">
                </div>
            </div>
            <div class="form-group">
                {!! Form::textarea('post1_text', null, ['class'=> 'form-control', 'id' => '', 'rows' => '5', 'cols' => '5', 'placeholder' => 'Type the post that you need..']) !!}
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12" id="post2-container">
            <div class="form-group">
                <div class="groups-list-container">
                    <label for="">Select a group from the list</label><br>
                    <select name="post2_page_id" id="" class="form-control select2 select-groups">
                        <option value="">Select a group..</option>
                    </select>
                    <input type="hidden" value="2" name="post2_sort">
                </div>
                <div class="pages-list-container hide">
                    <label for="">Select a page from the list</label><br>
                    <select name="post2_page_id" id="" class="form-control select2 select-pages" disabled>
                        <option value="">Select a page..</option>
                    </select>
                    <input type="hidden" value="1" name="post2_sort">
                </div>
            </div>
            <div class="form-group">
                {!! Form::textarea('post2_text', null, ['class'=> 'form-control', 'id' => '', 'rows' => '5', 'cols' => '5', 'placeholder' => 'Type the post that you need..']) !!}
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-md-12 pull-right">
            <button class="btn btn-lg btn-info" type="submit">Submit</button>
        </div>
    </div>
    {{ Form::close() }}
@endsection