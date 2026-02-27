@extends('layouts.app')

@section('content')

<div class="container tech-blog-main">
  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      <article class="post-show-card">
        <div class="card-accent"></div>
        <h1 class="h4 mb-2">{{ $post->title }}</h1>
        <div class="card-meta mb-3">
          <span title="Megtekintések">👁 {{ views($post)->unique()->count() }}</span>
          <span>Szerző: {{ $post->user->name ?? '–' }}</span>
          <span>Frissítette: {{ $post->updatedBy->name ?? $post->user->name ?? '–' }}</span>
          <span>Frissítve: @include('partials.time-ago', ['datetime' => $post->updated_at])</span>
        </div>
        @if ($post->tags->isNotEmpty())
          <div class="mb-3">
            @foreach ($post->tags as $item)
              <span class="card-tag">#{{ $item->name }}</span>
            @endforeach
          </div>
        @endif
        @isset($post->link)
          <p class="mb-3">
            <a href="{{ $post->link }}" target="_blank" rel="noopener" class="post-body">{{ $post->link }}</a>
          </p>
        @endisset
        <div class="post-body">{{ $post->body }}</div>
        @isset($file)
          <div class="card-meta mt-3 pt-3 border-top">
            <span class="text-muted small">Feltöltött fájl:</span>
            <a href="{{ route('fileDownload', $file->id) }}" class="btn btn-sm btn-outline-secondary" title="{{ $file->name }}">{{ $file->name }}</a>
          </div>
        @endisset
        @auth
          @if (Auth::user()->canEditPost($post))
            <div class="card-meta mt-3 pt-3 border-top card-actions">
              <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">Szerkesztés</a>
            </div>
          @endif
        @endauth
      </article>

      <section class="mt-4" aria-label="Hozzászólások">
        <livewire:post-comments :postId="$post->id" />
      </section>
    </main>
  </div>
</div>

@endsection
