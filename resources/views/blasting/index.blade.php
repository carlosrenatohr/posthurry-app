@extends('layouts.main')
@section('others-js')
    <script>
        $(function() {
            var html;
            $('.groups-modal-btn').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                html = $('.groups-container-' + id).clone();
                html.removeClass('hide');
                $('#myGroupsModal').find('.modal-body').html(html);
                $('#myGroupsModal').modal('show');
            });

            $('#myGroupsModal').on('hidden.bs.modal', function () {
                $(this).find('.modal-body').html('');
            });
        });
    </script>
@endsection
@section('content')
    <section class="heading">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-xs-8">
                    <h3>Blast History</h3>
                    <span style="font-size: 0.85em;">Most Recent 14 Days of Blasts shown</span>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <a href="{{ redirect()->getUrlGenerator()->previous() }}"
                       class="btn-warning pull-right">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="add">
        <div class="container">
            <table class="table table-striped" id="blasting-list-posts">
                <thead>
                <tr>
                    <th>Post</th>
                    <th>Blast Type</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                @if(count($user->blastings))
                @foreach($user->blastings as $index => $blasting)
                    <tr id="blasting-row-{{ $index }}" data-toggle="collapse" data-target="#collapse-{{$index}}"
                        class="clickable">
                        <td class="post">
                            {{ $blasting->post_text }}
                        </td>
                        <td>
                            @if( $blasting->groups_id ) Groups
                            @else Pages
                            @endif
                        </td>
                        <td>
                            @if( $blasting->groups_id ) {{ $blasting->groups_name }}  
                            @else {{ $blasting->pages_name }} 
                            @endif
                        </td>
                    </tr>
                    <div class="groups-container-{{ $index }} hide">
                        @if(!empty($blasting->groups))
                            <h3>Groups</h3>
                            @foreach($blasting->groups as $idx => $group)
                            <ul class="list-unstyled" id="">
                                <li> {{ $group }}
                                    <a href="https://fb.com/{{ $blasting->groups_posts[$idx] }}" target="_blank"
                                       class="btn btn-success" style="background-color: #3B5998;">Check it</a>
                                </li>
                                <br>
                            </ul>
                            @endforeach
                        @endif
                        <div class="divider"></div>
                        @if(!empty($blasting->pages))
                            <h3>Pages</h3>
                            @foreach($blasting->pages as $idx => $page)
                            <ul class="list-unstyled" id="">
                                <li> {{ $page }}
                                    <a href="https://fb.com/{{ $blasting->pages_posts[$idx] }}" target="_blank"
                                       class="btn btn-success" style="background-color: #3B5998;">Check it</a>
                                </li>
                                <br>
                            </ul>
                            @endforeach
                        @endif
                    </div>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    <div id="myGroupsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pages / Groups Linked</h4>
                </div>
                <div class="modal-body" style="max-height: 450px;overflow-y: scroll;">
                    <ul class="list-unstyled">
                        <li>Young Entertainment Professionals <button class="btn btn-success">Check it</button></li>
                        <br>
                        <li>Young Entertainment Professionals <button class="btn btn-success">Check it</button></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
