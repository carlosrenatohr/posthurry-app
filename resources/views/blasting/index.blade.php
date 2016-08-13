@extends('layouts.main')
@section('content')
    <div class="row-fluid">
        <h1 class="pull-left" style="font-size: 30px;padding: 30px 10px;">
            Blast History
        </h1>
        <div class="col-md-12">
            <table class="table table-striped" id="blasting-list-posts">
                <thead>
                <tr>
                    <th></th>
                    <th>Text</th>
                    <th># of Pages posted</th>
                    <th># of Groups posted</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->blastings as $index => $blasting)
                    <tr id="blasting-row-{{ $index }}" data-toggle="collapse" data-target="#collapse-{{$index}}"
                        class="clickable">
                        <td>
                            <a role="button" data-toggle="collapse"
                                href="#collapse-{{$index}}" aria-controls="collapse-{{ $index }}"
                                class="btn btn-warning" aria-expanded="true"
                            >Links
                            </a>
                        </td>
                        <td>
                            {{ $blasting->post_text }}
                        </td>
                        <td>
                            {{ count($blasting->pages) }}
                        </td>
                        <td>
                            {{ count($blasting->groups) }}
                        </td>
                    </tr>
                    <tr id="collapse-{{ $index }}" class="collapse" aria-expanded="true">
                        <td colspan="2">
                            <h3>Groups blasted</h3>
                                @if(!empty($blasting->groups))
                                <ul class="list-group">
                                    @foreach($blasting->groups as $idx => $group)
                                    <li class="list-group-item">
                                        {{ $group }} <a href="https://fb.com/{{ $blasting->groups_posts[$idx] }}" target="_blank"
                                                         class="btn btn-info"
                                                         style="background-color: #3B5998;">Check it</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                        </td>
                        <td class="2">
                            <h3>Pages blasted</h3>
                            @if(!empty($blasting->pages))
                            <ul class="list-group">
                                @foreach($blasting->pages as $idx => $page)
                                    <li class="list-group-item">
                                        {{ $page }}  <a href="https://fb.com/{{ $blasting->pages_posts[$idx] }}" target="_blank"
                                                         class="btn btn-info"
                                                         style="background-color: #3B5998;">Check it</a>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
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