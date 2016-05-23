@extends('layouts.main')
@section('content')
    <div class="row-fluid">
        <h1 class="pull-left" style="font-size: 30px;padding: 30px 10px;">
            List of your comparison
        </h1>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>First post on</th>
                    <th>Second post on</th>
                    <th>Created at</th>
                    <th>Is active?</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->comparisons as $comparison)
                    <tr>
                        <td>
                            <span style="font-weight: 800;">({{ $comparison->post1_sort == 1 ? 'Page' : 'Group' }})</span>
                            {{ $comparison->post1_page_name }}
                        </td>
                        <td>
                                <span style="font-weight: 800;">({{ $comparison->post2_sort  == 1 ? 'Page' : 'Group' }})</span>
                            {{ $comparison->post2_page_name }}
                        </td>
                        <td>{{ date('m-d-Y  h:i A', strtotime($comparison->created_at)) }}</td>
                        <td>
                            @if(!is_null($comparison->winner))
                                <i class="fa fa-remove" style="color: red;"></i>
                            @else
                                <i class="fa fa-check" style="color: green;"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('comparison/'. $comparison->id) }}" title="View Chart"><i class="fa fa-area-chart"></i></a>
                            {{--@if(!is_null($comparison->winner) || !is_null($comparison->massPosts))--}}
                                {{--<a href="#" title="Mass groups selected" data-toggle="modal" data-target="#massGroupsModal">--}}
                                    {{--<i class="fa fa-th-large"></i></a>--}}
                            {{--@endif--}}
                            </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-warning btn-lg pull-right">Back</a>
    </div>

    {{-- MODAL MASS GROUPS --}}
    <div class="modal fade" id="massGroupsModal" tabindex="-1" role="dialog" aria-labelledby="massGroupsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Groups/Pages selected to post in mass after comparison time</h4>
                </div>
                <div class="modal-body">
                    <div class="below-container">
                        <div class="col-md-6">
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title">Groups</h3>
                                </div>
                                <div class="panel-body groups" style="max-height:400px;overflow-y: scroll;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title">Pages</h3>
                                </div>
                                <div class="panel-body pages" style="max-height:400px;overflow-y: scroll;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save!</button>
                </div>
            </div>
        </div>
    </div>
@endsection