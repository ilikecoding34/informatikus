@extends('layouts.app')

@section('content')

@php
  $user->loadMissing('role');
@endphp

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Felhasználó</div>
    <a class="btn btn-sm btn-light" href="{{ route('users.index') }}">Vissza</a>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      <div class="post-show-card">
        <div class="card-accent"></div>
        <h5 class="mb-3">{{ $user->name }}</h5>
        <div class="form-group mb-2">
          <label class="text-muted small">E-mail</label>
          <p class="mb-0">{{ $user->email }}</p>
        </div>
        <div class="form-group mb-2">
          <label class="text-muted small">Jogosultság</label>
          <p class="mb-0">{{ $user->role->name ?? '–' }}</p>
        </div>
        <div class="card-meta mt-3">
          <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Szerkesztés</a>
        </div>
      </div>
    </main>
  </div>
</div>

@endsection
