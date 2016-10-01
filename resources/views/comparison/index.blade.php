@extends('layouts.main')
@section('content')
    <section class="heading">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <h3>A/B History</h3>
                    <span style="font-size: 0.85em;">Most Recent 14 Days of Blasts shown</span>
                </div>
                <div class="col-sm-3">
                    <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn-warning pull-right">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="add">
        <div class="container">
            <table class="table table-striped text-center">
                <thead>
                <tr>
                    <th>Post # 1</th>
                    <th>Post # 2</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Is Active?</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->comparisons as $comparison)
                    <tr>
                        <td class="text-left col-md-4">
                           <a href='{{ $comparison->post1_post_id }}'> {{ $comparison->post1_page_name }}</a>
                        </td>
                        <td class="text-left col-md-4">
                            <a href='{{ $comparison->post2_post_id }}'>{{ $comparison->post2_page_name }}</a>
                        </td>
                        <td>
                            {{ date("m-d-Y ", strtotime($comparison->created_at)) }}<br>
                            {{ date("h:iA", strtotime($comparison->created_at)) }}
                        </td>
                        <td>
                            @if(!is_null($comparison->winner))
                                No
                            @else
                                Yes
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('comparison/'. $comparison->id) }}" title="View Chart"><i class="fa fa-area-chart"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- MODAL MASS GROUPS --}}
    <div class="modal fade" id="massGroupsModal" tabindex="-1" role="dialog" aria-labelledby="massGroupsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Facebook Groups and Pages selected</h4>
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
