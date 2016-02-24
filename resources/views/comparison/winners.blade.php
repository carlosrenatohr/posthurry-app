@extends('layouts.main')
@section('content')
    <div class="row-fluid">
        <h1 class="pull-left" style="font-size: 30px;padding: 30px 10px;">
            List of winners
            <small>By {{ $comparison->first()->user->name }}</small>
        </h1>
        <div class="col-md-12">
            <table class="table table-striped">
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
                @foreach($comparison as $page)
                    <?php $winner_n = $page->winner;?>
                    @if($winner_n < 3)
                    <tr>
                        <td>{{ $page->{'post'. $winner_n .'_page_name'} }} ({{ $page->{'post'. $winner_n .'_sort'} == 1 ? "Page" : "Group" }}) </td>
                        <td>{{ $page->{'post'. $winner_n .'_text'} }} </td>
                        <td>{{ date('m-d-Y  h:i A', strtotime($page->created_at)) }}</td>
                        <td>
                            <b>Likes</b><label for="" class="badge">{{ $page->data_row->{'post'. $winner_n .'_likes'} }}</label>
                            Shares<label for="" class="badge">{{ $page->data_row->{'post'. $winner_n .'_shares'} }}</label>
                            Comments<label for="" class="badge">{{ $page->data_row->{'post'. $winner_n .'_comments'} }}</label>
                        </td>
                        <td><a href="{{ url('comparison/'. $page->id) }}">View Chart</a></td>
                    </tr>
                    @else
                        <tr>
                            <td>{{ $page->post1_page_name }} ({{ $page->post1_sort == 1 ? "Page" : "Group" }}) </td>
                            <td>{{ $page->post1_text }} </td>
                            <td>{{ date('m-d-Y  h:i A', strtotime($page->created_at)) }}</td>
                            <td>
                                <b>Likes</b><label for="" class="badge">{{ $page->data_row->post1_likes }}</label>
                                Shares<label for="" class="badge">{{ $page->data_row->post1_shares }}</label>
                                Comments<label for="" class="badge">{{ $page->data_row->post1_comments }}</label>
                            </td>
                            <td><a href="{{ url('comparison/'. $page->id) }}">View Chart</a></td>
                        </tr>
                        <tr>
                            <td>{{ $page->post2_page_name }} ({{ $page->post2_sort == 1 ? "Page" : "Group" }}) </td>
                            <td>{{ $page->post2_text }} </td>
                            <td>{{ date('m-d-Y  h:i A', strtotime($page->created_at)) }}</td>
                            <td>
                                <b>Likes</b><label for="" class="badge">{{ $page->data_row->post2_likes }}</label>
                                Shares<label for="" class="badge">{{ $page->data_row->post2_shares }}</label>
                                Comments<label for="" class="badge">{{ $page->data_row->post2_comments }}</label>
                            </td>
                            <td><a href="{{ url('comparison/'. $page->id) }}">View Chart</a></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-warning btn-lg pull-right">Back</a>
    </div>
@endsection