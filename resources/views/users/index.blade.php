@extends('layouts.app')

@section('content')

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Felhasználók</div>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      @if ($users->isEmpty())
        <div class="form-card">
          <div class="card-accent"></div>
          <p class="text-muted mb-0">Nincs felhasználó.</p>
        </div>
      @else
        <div class="form-card">
          <div class="card-accent"></div>
          <h5 class="mb-3">Felhasználók</h5>
          <div class="list-group list-group-flush">
            @foreach ($users as $item)
              <a href="{{ route('users.show', $item->id) }}" class="list-group-item list-group-item-action d-flex align-items-center px-0">
                <span class="font-weight-bold mr-2">{{ $item->name }}</span>
                <span class="text-muted small">{{ $item->email }}</span>
                @if ($item->role ?? null)
                  <span class="badge badge-secondary ml-2">{{ $item->role->name }}</span>
                @endif
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </main>
  </div>
</div>

@endsection
