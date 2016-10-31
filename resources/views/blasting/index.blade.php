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
                            @if( $blasting->groups_id )
                            <a href='http://fb.com/{{
                                (!empty($blasting->groups_published_id)) ?
                                $blasting->groups_published_id :
                                $blasting->groups_id }}' target='_blank'
                                >{{ $blasting->short_post_text }}</a>
                            @else 
                            <a href='http://fb.com/{{
                                (!empty($blasting->groups_published_id)) ?
                                $blasting->pages_published_id :
                                $blasting->pages_id }}' target='_blank'
                             >{{ $blasting->short_post_text }}</a>
                            @endif
                        </td>
                        <td>
                            @if( $blasting->groups_id ) Groups
                            @else Pages
                            @endif
                        </td>
                        <td>
                            @if( $blasting->groups_id ) <a href='http://fb.com/{{ $blasting->groups_id }}' target=_blank>{{ $blasting->groups_names }}</a>
                            @else <a href='http://fb.com/{{ $blasting->pages_id }}' target=_blank>{{ $blasting->pages_names }}</a> 
                            @endif
                        </td>
                    </tr>
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
