@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-end">
            <a class="btn btn-secondary" href="{{route('main')}}" role="button">Vissza</a>
    </div>
</div>

<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="list-group">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{{$post->body}}</p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-left">
                                    <small class="text-muted">Szerző: {{$post->user->name}}</small>
                                </p>
                            </div>
                            <div class="col">
                                <p class="card-text text-right">
                                    <small class="text-muted">Utoljára frissítve: {{$post->updated_at->diffForHumans(null, true).'ja' }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container">
    <div class="row justify-content-center">
        <h3>Hozzászólások</h3>
    </div>
</div>


<div class="container mt-2 pt-3 bg-secondary" >
    <div class="row justify-content-center">

        <div class="col-md-12 ">
            <div class="list-group">
                @foreach ($post->comments as $item)
                <div class="card mb-3">
                    <div class="card-body bg-light">
                        <p class="card-text">{{$item->body}}</p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-left">
                                    <small class="text-muted">Szerző: {{$item->user->name}}</small>
                                </p>
                            </div>
                            <div class="col">
                                <p class="card-text text-right">
                                    <small class="text-muted">Utoljára frissítve: {{$item->updated_at->diffForHumans(null, true).'ja' }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


  @endsection
