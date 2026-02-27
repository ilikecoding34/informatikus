@extends('layouts.app')

@section('content')

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Bejegyzések</div>
    <a class="btn btn-sm btn-light" href="{{ route('posts.create') }}" role="button">Új bejegyzés írása</a>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      @if (session('message'))
        <div class="alert alert-success mb-3">{{ session('message') }}</div>
      @endif
      @if ($posts->isNotEmpty())
        <div class="posts-grid">
          @foreach ($posts as $item)
            <article class="post-card position-relative {{ $item->is_active ? '' : 'opacity-75' }}">
              <a href="{{ route('posts.show', $item->id) }}" class="post-card-link">
                <div class="card-accent"></div>
                @if (!$item->is_active)
                  <span class="badge badge-secondary position-absolute" style="top: 0.5rem; right: 0.5rem;">Inaktív</span>
                @endif
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
                <span title="Hozzászólások">💬 {{ $item->comments_count ?? 0 }}</span>
                <span title="Utoljára módosította">{{ $item->updatedBy->name ?? $item->user->name ?? '–' }}</span>
                <span title="Frissítve">@include('partials.time-ago', ['datetime' => $item->updated_at])</span>
              </div>
              <div class="card-meta card-actions">
                <a href="{{ route('singlePost', $item->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Megtekintés" aria-label="Megtekintés">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.39-.83.95-1.465 1.465C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>
                </a>
                @if (auth()->user()->canEditPost($item))
                  <a href="{{ route('posts.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Szerkesztés" aria-label="Szerkesztés">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5v.5H6v-.5a.5.5 0 0 1 .5-.5h.5v-.5A.5.5 0 0 1 8 10h.5v-.5A.5.5 0 0 1 9 9h.5V8.5h.5a.5.5 0 0 1 .5.5v.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 7.439 11H6.5v-.5a.5.5 0 0 1 .5-.5h.5v-.5a.5.5 0 0 1 .5-.5h.439l2.353-2.353z"/></svg>
                  </a>
                  @if ($item->is_active)
                    <form action="{{ route('posts.deactivate', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Biztosan deaktiválod a bejegyzést?');">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-secondary" title="Deaktiválás" aria-label="Deaktiválás">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M5.5 3A1.5 1.5 0 0 0 4 4.5v7A1.5 1.5 0 0 0 5.5 13h5a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 10.5 3h-5zM5 4.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1-.5-.5v-7z"/><path d="M8 5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0v-4A.5.5 0 0 1 8 5z"/></svg>
                      </button>
                    </form>
                  @else
                    <form action="{{ route('posts.activate', $item->id) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-success" title="Aktiválás" aria-label="Aktiválás">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                      </button>
                    </form>
                  @endif
                  <form action="{{ route('posts.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Biztosan törlöd a bejegyzést?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Törlés" aria-label="Törlés">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 1-1 0V6a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6a.5.5 0 0 1 1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
                    </button>
                  </form>
                @endif
              </div>
            </article>
          @endforeach
        </div>
      @else
        <p class="empty-state">Nincs megjeleníthető bejegyzés.</p>
      @endif
    </main>
  </div>
</div>

@endsection
