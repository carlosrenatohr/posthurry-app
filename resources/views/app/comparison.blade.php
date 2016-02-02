@extends('layouts.main')
@section('content')
    <div class="row-fluid">
    <h1 id="fb-welcome">Hurry post</h1>
    <div class="col-md-12">
        {!!  \Form::open(['url' => '', 'method' => 'post', 'class' => 'form-horizontal'])!!}
        <p>Select where You want to post.</p>
        <div class="radio">
            <input type="radio" value="1" name="typeToPost">
            Page
        </div>
        <div class="radio">
            <input type="radio" value="2" name="typeToPost">
            Group
        </div>
    </div>
    </div>
    <div class="row-fluid">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="">Select a group from the list</label>
        <select name="" id="select-pages" class="form-control select2">
            <option value="">Select a page..</option>
        </select>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="">Select other one to compare</label>
        <select name="" id="select-groups" class="form-control select2">
            <option value="">Select a group..</option>
        </select>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::textarea('post', null, ['class'=> 'form-control', 'id' => '', 'rows' => '5', 'cols' => '5', 'placeholder' => 'Type the post that you need..']) !!}
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