@extends('layouts.app')

@section('content')


<div class="container mt-2">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="list-group">
                @foreach ($comments as $item)
                <div class="card mb-3">
                    <a href="{{route('comments.edit', $item->id)}}" class="list-group-item list-group-item-action">
                    <div class="card-body">
                        <div class="card-title">
                            @if (isset($item->post))
                            Bejegyzés címe: {{$item->post->title}}
                            @else
                                Törölt bejegyzés
                            @endif
                        </div>
                        <p class="card-text">{{$item->body}}</p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-left">
                                    <small class="text-muted">Szerző: {{$item->user->name}}</small>
                                </p>
                            </div>
                            <div class="col">
                                <p class="card-text text-right">
                                    <small class="text-muted">@include('partials.time-ago', ['datetime' => $item->updated_at])</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user())
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
