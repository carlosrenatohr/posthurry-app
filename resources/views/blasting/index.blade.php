@extends('layouts.main')
@section('content')
    <div class="row">
        <h1 class="hurrypost-title">
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
@endsection