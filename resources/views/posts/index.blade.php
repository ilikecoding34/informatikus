@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
            <a class="btn btn-info" href="{{route('posts.create')}}" role="button">Új bejegyzés írása</a>
    </div>
</div>

<div class="container mt-2">
            <div class="list-group ">
                @foreach ($posts as $item)
                <div class="row justify-content-md-center">
                <div class="col col-6">
                    <div class="card mb-3">
                        <a href="{{route('posts.show', $item->id)}}" class="list-group-item list-group-item-action">
                        <div class="card-body">
                            <h5 class="card-title">{{$item->title}}</h5>
                            <p class="card-text">{{$item->body}}</p>
                            <div class="row">
                                <div class="col">
                                    <p class="card-text text-left">
                                        <small class="text-muted">Szerző:{{$item->user->name}}</small>
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
                </div>
                <div class="col col-1">
                    <form action="{{ route('posts.destroy',$item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

  @endsection
