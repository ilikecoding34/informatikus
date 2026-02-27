@extends('layouts.app')

@section('content')
@include('cookie-consent::index')

<div class="container tech-blog-main">
  <div class="topic-strip">
    <div class="topic-label">Témakörök</div>
    <div class="topic-pills">
      @foreach ($tags as $tag)
        <a href="/category/{{ $tag->name }}" class="topic-pill" data-topic="{{ strtolower($tag->name) }}">{{ $tag->name }}</a>
      @endforeach
    </div>
  </div>

  <div class="main-three-cols {{ !$showLeft ? 'main-no-left' : '' }} {{ !$showRight ? 'main-no-right' : '' }}">
    @if ($showLeft)
      <aside class="main-col main-col-left">
        <div class="main-sidebar-card">
          @include('partials.sidebar-content', ['type' => $leftSidebar])
        </div>
      </aside>
    @endif

    <main class="main-col main-col-center">
      @if ($posts->isNotEmpty())
        <div class="posts-grid">
          @foreach ($posts as $item)
            <article class="post-card">
              <a href="{{ route('singlePost', $item->id) }}" class="post-card-link">
                <div class="card-accent"></div>
                <h2 class="card-title">{{ $item->title }}</h2>
                <p class="card-excerpt">{{ Str::limit($item->body, 160) }}</p>
                <div class="card-tags">
                  @foreach ($item->tags as $tag)
                    <span class="card-tag">#{{ $tag->name }}</span>
                  @endforeach
                </div>
              </a>
              <div class="card-meta">
                <span title="Megtekintések">👁 {{ views($item)->unique()->count() }}</span>
                <span title="Hozzászólások">💬 {{ count($item->comments) }}</span>
                <span title="Szerző">
                  @if ($item->user != null)
                    {{ $item->user->name }}
                  @else
                    Törölt felhasználó
                  @endif
                </span>
                <span>@include('partials.time-ago', ['datetime' => $item->updated_at])</span>
              </div>
            </article>
          @endforeach
        </div>
        <div class="pagination-wrap">
          {{ $posts->links() }}
        </div>
      @else
        <p class="empty-state">Nincs megjeleníthető bejegyzés.</p>
      @endif
    </main>

    @if ($showRight)
      <aside class="main-col main-col-right">
        <div class="main-sidebar-card">
          @include('partials.sidebar-content', ['type' => $rightSidebar])
        </div>
      </aside>
    @endif
  </div>
</div>
@endsection
