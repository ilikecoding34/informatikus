@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

            <div class="card-body ">
                <div class="card-title">
                    <div class="container">
                        <div class="row justify-content-end">
                                <a class="btn btn-secondary" href="{{route('posts.index')}}" role="button">Vissza</a>
                        </div>
                    </div>
                </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Cím</label>
                <input type="text" class="form-control" disabled name="title" id="title" value="{{$post->title}}">
                <div class="form-text">Ez a bejegyzés címe lesz</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Link</label>
                <input type="text" class="form-control" disabled name="title" id="title" value="{{$post->link}}">
            </div>
            <div class="mb-3">
                <label for="floatingTextarea" class="form-label">Szoveg</label>
                <textarea class="form-control" rows={{str_word_count($post->body)/12}} placeholder="Leave a comment here" disabled name="content">{{$post->body}}</textarea>
            </div>
            <div class="col-xs-2">
            @if ($post->tags->isNotEmpty())
                @foreach ($post->tags as $item)
                    <span class="badge badge-primary">{{$item->name}}</span>
                @endforeach
            @endif
            </div>
            @if (auth()->user()->id == $post->user_id)
                <a class="btn btn-secondary" href="{{route('posts.edit', $post->id)}}" role="button">Szerkeszt</a>
            @endif
            </div>
            </div>
<br>

                @foreach ($post->comments as $item)
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
                                    <small class="text-muted"><timeupdate inputtime="{{$item->updated_at}}"></timeupdate></small>
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

  @endsection
