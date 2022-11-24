@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach ($tags as $tag)
            <a href="/category/{{$tag->name}}">
                <span class="badge badge-primary">{{$tag->name}}</span>
            </a>
            @endforeach
            <div class="list-group">
                @if ($posts->isNotEmpty())
                <div class="col-10">
                @foreach ($posts as $item)
                        @if($loop->odd)
                            <div class="row justify-content-md-center">
                        @endif
                            <div class="col-5">
                                <div class="card mb-3">
                                    <a href="{{route('singlePost', $item->id)}}" class="list-group-item list-group-item-action">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$item->title}}</h5>

                                        <p class="card-text">{{Str::limit($item->body, 200)}}</p>
                                        <div class="row">
                                            <div class="col">
                                                <p class="card-text text-left">
                                                    <small>Megtekintés: {{$item->view}}</small><br>
                                                    <small>Hozzászólások: {{count($item->comments)}}</small><br>
                                                    <small class="text-muted">Szerző:
                                                        @if ($item->user != null)
                                                        {{$item->user->name}}
                                                        @else
                                                        Törölt felhasználó
                                                        @endif
                                                    </small>
                                                </p>
                                            </div>
                                            <div class="col">
                                                <p class="card-text text-right">
                                                    <small class="text-muted">Utoljára frissítve: {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        @if($loop->even)
                            </div>
                        @endif

                @endforeach
            </div>
                @else
                    Nincs megjeleníthető bejegyzés
                @endif
                <div>
                {{ $posts->links() }}
            </div>
            </div>
        </div>

    </div>
</div>

  @endsection
