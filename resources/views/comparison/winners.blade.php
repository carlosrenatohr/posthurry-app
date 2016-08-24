@extends('layouts.main')
@section('content')
<section class="heading">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <h3>List of Winners
                @if(count($comparison))
                    <small style="font-weight:bold; color:#2ac6ec">By {{ $comparison->first()->user->name }}</small>
                </h3>
                @endif
            </div>
            <div class="col-sm-3">
                <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn-warning pull-right">Back</a>
            </div>
        </div>
    </div>
</section>

<section class="add">
    <div class="container">
        <table class="table table-striped text-center table-responsive">
            <thead>
            <tr>
                <th>Pages / Groups</th>
                <th>Text</th>
                <th class="text-center">Created</th>
                <th class="text-center">Likes</th>
                <th class="text-center">Shares</th>
                <th class="text-center">Comments</th>
                <th class="text-center">Actions</th>
                <th class="text-center">Blast Time</th>
            </tr>
            </thead>
            <tbody>
            @if (count($comparison))
            @foreach($comparison as $page)
                <?php $winner_n = $page->winner;?>
                <tr>
                    <td class="text-left col-md-2">
                        <b>({{ $page->{'post'. $winner_n .'_sort'} == 1 ? "Page" : "Group" }})</b>
                        {{ $page->{'post'. $winner_n .'_page_name'} }}
                    </td>
                    <td class="text-left col-md-2">
                        {{ $page->{'post'. $winner_n .'_text'} }}
                    </td>
                    <td>
                        {{ date('m-d-Y', strtotime($page->created_at)) }}<br>
                        {{ date('h:iA', strtotime($page->created_at)) }}
                    </td>
                    <td>
                        <label title="Likes">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        {{ $page->data_row->{'post'. $winner_n .'_likes'} }}
                        </label>
                    </td>
                    <td>
                        <label title="Shares">
                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                        {{ $page->data_row->{'post'. $winner_n .'_shares'} }}
                        </label>
                    </td>
                    <td>
                        <label title="Comments">
                        <i class="fa fa-comment" aria-hidden="true"></i>
                        {{ $page->data_row->{'post'. $winner_n .'_comments'} }}
                        </label>
                    </td>
                    <td>
                        <a href="{{ url('comparison/'. $page->id) }}">
                            <i class="fa fa-area-chart"></i>
                        </a>
                    </td>
                    <td>
                        @if(isset($page->massPosts))
                            {{ date('m-d-Y', strtotime($page->massPosts->blastAt)) }}<br>
                            {{ date('h:iA', strtotime($page->massPosts->blastAt)) }}
                        @endif
                    </td>
                    <td></td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</section>
@endsection