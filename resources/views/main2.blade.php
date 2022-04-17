@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if ($settings->col_comment)
        <div class="col-3 order-{{$settings->col_comment}}">
            @if ($post->comments->isNotEmpty())
                @foreach ($post->comments as $item)
                <div class="card mb-4">
                    <div class="card-body">
                        {{$item->body}}
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        @endif
        <div class="@if($settings->col_count == 1)
            col-12
            @elseif($settings->col_count == 2)
            col-9
            @elseif($settings->col_count == 3)
            col-6
            @endif
             order-{{$settings->col_post}}">
             <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                </div>
                <div class="card-body">
                    @if ($post->tags->isNotEmpty())
                        @foreach ($post->tags as $item)
                        <span class="badge badge-primary">{{$item->name}}</span>
                        @endforeach
                    @endif
                <div class="my-2">
                    <a href="{{$post->link}}" class="card-link">Link</a>
                </div>
                <p class="card-text">{{$post->body}}</p>
                </div>
              </div>

        </div>


        @if ($settings->col_related)
        <div class="col-3 order-{{$settings->col_related}}">
            Ez mindig a related rész
        </div>
        @endif

    </div>
</div>
@endsection
