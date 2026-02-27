@extends('layouts.app')

@section('content')

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Felhasználó szerkesztése</div>
    <a class="btn btn-sm btn-light" href="{{ route('users.index') }}">Vissza</a>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      <div class="form-card">
        <div class="card-accent"></div>
        <h5 class="mb-3">{{ $user->name }}</h5>
        <form method="POST" action="{{ route('users.update', $user->id) }}">
          @csrf
          @method('PUT')
          <div class="form-group mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required>
          </div>
          <div class="form-group mb-3">
            <label for="role" class="form-label">Jogosultság</label>
            <select name="role" id="role" class="form-control" required>
              @foreach ($roles as $item)
                <option value="{{ $item->id }}" {{ old('role', $user->role_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
      </div>
    </main>
  </div>
</div>

@endsection
