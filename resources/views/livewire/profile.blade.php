<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Profil</div>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      {{-- Profile data --}}
      <div class="form-card mb-4">
        <div class="card-accent"></div>
        <h5 class="mb-3">Személyes adatok</h5>
        @if (session()->has('profile_message'))
          <div class="alert alert-success" role="alert">
            {{ session('profile_message') }}
          </div>
        @endif
        <form wire:submit="saveProfile">
          <div class="form-group mb-3">
            <label for="name">Név</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="email">E-Mail cím</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email">
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <hr class="my-4">
          <p class="text-muted small">Jelszó megváltoztatása (hagyd üresen, ha nem változtatsz):</p>
          <div class="form-group mb-3">
            <label for="current_password">Jelenlegi jelszó</label>
            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" wire:model="current_password">
            @error('current_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="password">Új jelszó</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password">
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="password_confirmation">Új jelszó újra</label>
            <input id="password_confirmation" type="password" class="form-control" wire:model="password_confirmation">
          </div>
          <button type="submit" class="btn btn-primary">Személyes adatok mentése</button>
        </form>
      </div>

      {{-- Layout settings --}}
      <div class="form-card">
        <div class="card-accent"></div>
        <h5 class="mb-3">Főoldal elrendezése</h5>
        @if (session()->has('layout_message'))
          <div class="alert alert-success" role="alert">
            {{ session('layout_message') }}
          </div>
        @endif
        <p class="text-muted mb-4">
          Válaszd ki, mi jelenjen meg a bal és a jobb oldali oszlopban. A középső oszlop (összes bejegyzés) mindig látható. Mindkét oldalról választhatsz egyet az alábbi lehetőségek közül; ha „Nincs” van kiválasztva, az oszlop rejtve marad.
        </p>
        <form wire:submit="saveLayout">
          <div class="form-group mb-3">
            <label for="left_sidebar">Bal oldali oszlop</label>
            <select id="left_sidebar" class="form-control" wire:model.live="left_sidebar">
              @foreach ($sidebarOptions as $value => $label)
                @if ($value === '' || $value !== $right_sidebar)
                  <option value="{{ $value }}">{{ $label }}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="right_sidebar">Jobb oldali oszlop</label>
            <select id="right_sidebar" class="form-control" wire:model.live="right_sidebar">
              @foreach ($sidebarOptions as $value => $label)
                @if ($value === '' || $value !== $left_sidebar)
                  <option value="{{ $value }}">{{ $label }}</option>
                @endif
              @endforeach
            </select>
            @error('right_sidebar')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary">Elrendezés mentése</button>
        </form>
      </div>
    </main>
  </div>
</div>
