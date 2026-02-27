@extends('layouts.app')

@section('content')

@php
  $post->loadMissing(['tags', 'user', 'updatedBy', 'comments.user']);
@endphp

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Bejegyzés</div>
    <div>
      <a class="btn btn-sm btn-light mr-2" href="{{ route('posts.index') }}">Vissza</a>
      <a class="btn btn-sm btn-outline-light mr-2" href="{{ route('singlePost', $post->id) }}" target="_blank">Megtekintés az oldalon</a>
      @if (auth()->user()->canEditPost($post))
        <a class="btn btn-sm btn-light" href="{{ route('posts.edit', $post->id) }}">Szerkesztés</a>
      @endif
    </div>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      <div class="post-show-card">
        <div class="card-accent"></div>
        <h5 class="mb-3">{{ $post->title }}</h5>
        @if ($post->tags->isNotEmpty())
          <div class="mb-3">
            @foreach ($post->tags as $tag)
              <span class="card-tag">#{{ $tag->name }}</span>
            @endforeach
          </div>
        @endif
        <div class="form-group mb-2">
          <label class="text-muted small">Szerző</label>
          <p class="mb-0">{{ $post->user->name ?? '–' }}</p>
        </div>
        <div class="form-group mb-2">
          <label class="text-muted small">Utoljára módosította</label>
          <p class="mb-0">{{ $post->updatedBy->name ?? $post->user->name ?? '–' }}</p>
        </div>
        <div class="form-group mb-2">
          <label class="text-muted small">Frissítve</label>
          <p class="mb-0">@include('partials.time-ago', ['datetime' => $post->updated_at])</p>
        </div>
        @if ($post->link)
          <div class="form-group mb-2">
            <label class="text-muted small">Link</label>
            <p class="mb-0"><a href="{{ $post->link }}" target="_blank" rel="noopener">{{ $post->link }}</a></p>
          </div>
        @endif
        <div class="form-group mb-0">
          <label class="text-muted small">Szöveg</label>
          <div class="post-body mt-1">{{ $post->body }}</div>
        </div>
        <div class="card-meta mt-3 pt-3 border-top">
          <a href="{{ route('singlePost', $post->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">Megtekintés az oldalon</a>
          @if (auth()->user()->canEditPost($post))
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Szerkesztés</a>
          @endif
        </div>
      </div>

      @if ($post->comments->isNotEmpty())
        <div class="form-card">
          <div class="card-accent"></div>
          <h5 class="mb-3">Hozzászólások ({{ $post->comments->count() }})</h5>
          <div class="list-group list-group-flush">
            @foreach ($post->comments as $item)
              <div class="list-group-item px-0">
                <p class="mb-1">{{ Str::limit($item->body, 200) }}</p>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <small class="text-muted">{{ $item->user->name ?? '–' }} · @include('partials.time-ago', ['datetime' => $item->updated_at])</small>
                  <a href="{{ route('comments.edit', $item) }}" class="btn btn-sm btn-outline-primary mt-1">Szerkesztés</a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </main>
  </div>
</div>

@endsection
