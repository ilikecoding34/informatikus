@php
  $titles = [
    'newest' => 'Legújabb 5 bejegyzés',
    'most_viewed' => 'Legtöbbet megtekintett',
    'tags' => 'Témakörök',
    'categories' => 'Kategóriák',
    'recent_comments' => 'Legutóbbi hozzászólások',
  ];
  $title = $titles[$type ?? ''] ?? '';
@endphp
@if ($title !== '')
  <h3 class="main-sidebar-title">{{ $title }}</h3>
@endif

@switch($type ?? '')
  @case('newest')
    <ul class="main-sidebar-list">
      @foreach ($newestPosts ?? [] as $item)
        <li>
          <a href="{{ route('singlePost', $item->id) }}" class="main-sidebar-link">
            <span class="main-sidebar-link-title">{{ Str::limit($item->title, 40) }}</span>
            <span class="main-sidebar-meta">👁 {{ views($item)->unique()->count() }}</span>
          </a>
        </li>
      @endforeach
    </ul>
    @break
  @case('most_viewed')
    <ul class="main-sidebar-list">
      @foreach ($mostViewedPosts ?? [] as $item)
        <li>
          <a href="{{ route('singlePost', $item->id) }}" class="main-sidebar-link">
            <span class="main-sidebar-link-title">{{ Str::limit($item->title, 40) }}</span>
            <span class="main-sidebar-meta">👁 {{ views($item)->unique()->count() }}</span>
          </a>
        </li>
      @endforeach
    </ul>
    @break
  @case('tags')
    <ul class="main-sidebar-list main-sidebar-tags">
      @foreach ($tags ?? [] as $tag)
        <li>
          <a href="/category/{{ $tag->name }}" class="main-sidebar-link">{{ $tag->name }}</a>
        </li>
      @endforeach
    </ul>
    @break
  @case('categories')
    <ul class="main-sidebar-list">
      @foreach ($categoriesWithCount ?? [] as $cat)
        <li>
          <a href="{{ route('by-category', $cat->id) }}" class="main-sidebar-link">
            <span class="main-sidebar-link-title">{{ $cat->name }}</span>
            <span class="main-sidebar-meta">{{ $cat->posts_count }} bejegyzés</span>
          </a>
        </li>
      @endforeach
    </ul>
    @break
  @case('recent_comments')
    <ul class="main-sidebar-list">
      @foreach ($recentComments ?? [] as $comment)
        <li>
          <a href="{{ route('singlePost', $comment->post_id) }}#comments" class="main-sidebar-link">
            <span class="main-sidebar-link-title">{{ Str::limit($comment->body, 35) }}</span>
            <span class="main-sidebar-meta">{{ $comment->user->name ?? '?' }} · {{ Str::limit($comment->post->title ?? '', 25) }}</span>
          </a>
        </li>
      @endforeach
    </ul>
    @break
  @default
    <p class="text-muted small mb-0">Nincs megjeleníthető tartalom.</p>
@endswitch
