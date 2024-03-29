@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
             <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <small>Megtekintés: {{$post->view}}</small>
                </div>
                <div class="card-body">
                    @if ($post->tags->isNotEmpty())
                        @foreach ($post->tags as $item)
                        <span class="badge badge-primary">{{$item->name}}</span>
                        @endforeach
                    @endif
                @isset($post->link)
                <div class="my-2">
                    <a href="{{$post->link}}" class="card-link">Link</a>
                </div>
                @endisset
                <p class="card-text">{{$post->body}}</p>
                </div>
                @isset($file)
                <div class="form-group mb-2 d-flex justify-content-center">
                    <p class="mr-2">Feltöltött file:</p>
                    <a href="{{route('fileDownload', $file->id)}}">
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title={{$file->name}}>
                            {{$file->name}}
                        </button>
                    </a>
                </div>
                @endisset

<hr>
<p class="text-center">Hozzászólások</p>
@if ($post->comments->isNotEmpty())
@foreach ($post->comments as $item)
    <div class="card m-2">
        <div class="card-body">
            <div class="row">
                <div
                @auth
                class="col-10"
                @else
                class="col-12"
                @endauth
                >
                    <p class="card-text">{{$item->body}}</p>
                    <div class="row">
                        <div class="col-7">
                            <p class="card-text text-left">
                                <small>Szerző: {{$item->user->name}}</small>
                            </p>
                        </div>
                        <div class="col-5">
                            <div class="card-text text-rigth">
                                <timeupdate inputtime="{{$item->updated_at}}"></timeupdate>
                            </div>
                        </div>
                    </div>
                </div>
                @auth
                <div class="col-2">
                <div class="m-2">

                @if (auth()->user()->id == $item->user_id)
                <a href="{{ route('comments.edit',$item) }}">Szerkesztés</a>
                <form action="{{ route('comments.destroy',$item) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button>
                </form>
                @endif


            </div>
            </div>
            @endauth
            </div>
        </div>
    </div>
@endforeach
@endif
</div>
</div>
</div>
@if (Auth::user())
    @include('comments.create')
@endif
</div>
@endsection
