@extends('layouts.main')
@section('content')
    <style>
        .table-winners td label {
            margin-right: 5px;
        }
    </style>
    <div class="row-fluid">
        <h1 class="pull-left" style="font-size: 30px;padding: 30px 10px;">
            List of winners
            @if(count($comparison))
            <small>By {{ $comparison->first()->user->name }}</small>
            @endif
        </h1>
        <div class="col-md-12">
            <table class="table table-striped table-winners">
                <thead>
                <tr>
                    <th>Page/group located</th>
                    <th>Content</th>
                    <th>Created at</th>
                    <th>Stats</th>
                    <th>Link</th>
                </tr>
                </thead>
                <tbody>
                @if (count($comparison))
                    @foreach($comparison as $page)
                        <?php $winner_n = $page->winner;?>
                        @if($winner_n < 3)
                        <tr>
                            <td>
                                <b>({{ $page->{'post'. $winner_n .'_sort'} == 1 ? "Page" : "Group" }})</b>
                                {{ $page->{'post'. $winner_n .'_page_name'} }}
                            </td>
                            <td>{{ $page->{'post'. $winner_n .'_text'} }} </td>
                            <td>{{ date('m-d-Y  h:i A', strtotime($page->created_at)) }}</td>
                            <td>
                                <label title="Likes"><i class="fa fa-thumbs-o-up"></i><span class="badge">{{ $page->data_row->{'post'. $winner_n .'_likes'} }}</span></label>
                                <label title="Shares"><i class="fa fa-share-alt"></i><span class="badge">{{ $page->data_row->{'post'. $winner_n .'_shares'} }}</span></label>
                                <label title="Comments"><i class="fa fa-comment"></i><span class="badge">{{ $page->data_row->{'post'. $winner_n .'_comments'} }}</span></label>
                            </td>
                            <td><a href="{{ url('comparison/'. $page->id) }}"><i class="fa fa-area-chart"></i>Chart</a></td>
                        </tr>
                        @else
                            <tr>
                                <td>
                                    <b>({{ $page->post1_sort == 1 ? "Page" : "Group" }})</b>
                                    {{ $page->post1_page_name }}
                                </td>
                                <td>{{ $page->post1_text }} </td>
                                <td>{{ date('m-d-Y  h:i A', strtotime($page->created_at)) }}</td>
                                <td>
                                    <label title="Likes"><i class="fa fa-thumbs-o-up"></i><span class="badge">{{ $page->data_row->post1_likes }}</span></label>
                                    <label title="Shares"><i class="fa fa-share-alt"></i><span  class="badge">{{ $page->data_row->post1_shares }}</span></label>
                                    <label title="Comments"><i class="fa fa-comment"></i><span  class="badge">{{ $page->data_row->post1_comments }}</span></label>
                                </td>
                                <td><a href="{{ url('comparison/'. $page->id) }}"><i class="fa fa-area-chart"></i>Chart</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>({{ $page->post2_sort == 1 ? "Page" : "Group" }})</b>
                                    {{ $page->post2_page_name }}
                                </td>
                                <td>{{ $page->post2_text }} </td>
                                <td>{{ date('m-d-Y  h:i A', strtotime($page->created_at)) }}</td>
                                <td>
                                    <label title="Likes"><i class="fa fa-thumbs-o-up"></i><span  class="badge">{{ $page->data_row->post2_likes }}</span></label>
                                    <label title="Shares"><i class="fa fa-share-alt"></i><span  class="badge">{{ $page->data_row->post2_shares }}</span></label>
                                    <label title="Comments"><i class="fa fa-comment"></i><span  class="badge">{{ $page->data_row->post2_comments }}</span></label>
                                </td>
                                <td><a href="{{ url('comparison/'. $page->id) }}"><i class="fa fa-area-chart"></i>Chart</a></td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <p>There is not still any comparison expired.</p>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-warning btn-lg pull-right">Back</a>
    </div>
@endsection