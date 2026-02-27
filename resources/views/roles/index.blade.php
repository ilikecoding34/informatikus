@extends('layouts.app')

@section('content')

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Jogosultságok</div>
    <a class="btn btn-sm btn-light" href="{{ route('roles.create') }}">Új jogosultság</a>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      @if ($roles->isEmpty())
        <div class="form-card">
          <div class="card-accent"></div>
          <p class="text-muted mb-0">Nincs jogosultság. Hozz létre egyet.</p>
        </div>
      @else
        <div class="form-card">
          <div class="card-accent"></div>
          <h5 class="mb-3">Jogosultságok</h5>
          <div class="list-group list-group-flush">
            @foreach ($roles as $item)
              <a href="{{ route('roles.show', $item->id) }}" class="list-group-item list-group-item-action d-flex align-items-center px-0">
                <span class="font-weight-bold">{{ $item->name }}</span>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </main>
  </div>
</div>

@endsection
