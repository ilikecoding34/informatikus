@extends('layouts.app')

@section('content')

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Jogosultság</div>
    <a class="btn btn-sm btn-light" href="{{ route('roles.index') }}">Vissza</a>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      <div class="post-show-card">
        <div class="card-accent"></div>
        <h5 class="mb-3">{{ $role->name }}</h5>
        <div class="card-meta">
          <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">Szerkesztés</a>
        </div>
      </div>
    </main>
  </div>
</div>

@endsection
