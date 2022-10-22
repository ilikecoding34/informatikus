@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-end">
            <a class="btn btn-secondary" href="{{route('posts.index')}}" role="button">Vissza</a>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

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
                    <textarea class="form-control" placeholder="Leave a comment here" disabled name="content">{{$post->body}}</textarea>
                </div>
                <div class="col-xs-2">
                    @if ($post->tags->isNotEmpty())
                        @foreach ($post->tags as $item)
                            <span class="badge badge-primary">{{$item->name}}</span>
                        @endforeach
                    @endif
                </div>
                <a class="btn btn-secondary" href="{{route('posts.edit', $post->id)}}" role="button">Szerkeszt</a>

                @include('comments.index')

        </div>
    </div>
</div>

  @endsection
