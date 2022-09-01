@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="list-group">
                @foreach ($posts as $item)
                <div class="card mb-3">
                    <a href="{{route('singlePost', $item->id)}}" class="list-group-item list-group-item-action">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->title}}</h5>
                        <p class="card-text">{{Str::limit($item->body, 200)}}</p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-left">
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
                                    <small class="text-muted">Utoljára frissítve: {{$item->updated_at->diffForHumans(null, true).'ja' }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
                <div>
                {{ $posts->links() }}
            </div>
            </div>
        </div>

    </div>
</div>

  @endsection
