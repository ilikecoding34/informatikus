<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Kategóriák</div>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
          {{ session('message') }}
        </div>
      @endif
      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      {{-- Create form --}}
      <div class="form-card mb-4">
        <div class="card-accent"></div>
        <h5 class="mb-3">Új kategória</h5>
        <form wire:submit="save">
          <div class="form-group mb-2">
            <label for="name">Kategória név</label>
            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="pl. Laravel">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
      </div>

      {{-- List --}}
      <div class="form-card">
        <div class="card-accent"></div>
        <h5 class="mb-3">Kategóriák</h5>
        @if ($categories->isEmpty())
          <p class="text-muted mb-0">Még nincs kategória. Hozz létre egyet fent.</p>
        @else
          <div class="list-group list-group-flush">
            @foreach ($categories as $category)
              <div class="list-group-item px-0">
                @if ($editId === $category->id)
                  <form wire:submit="update">
                    <div class="form-group mb-2">
                      <input type="text" class="form-control form-control-sm @error('editName') is-invalid @enderror" wire:model="editName">
                      @error('editName')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Mentés</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="cancelEdit">Mégse</button>
                  </form>
                @else
                  <span class="mr-2 font-weight-bold">{{ $category->name }}</span>
                  <span class="text-muted small mr-2">{{ $category->posts_count }} bejegyzés</span>
                  <a href="{{ route('by-category', $category->id) }}" class="btn btn-sm btn-outline-secondary mr-1" target="_blank">Megtekintés</a>
                  <button type="button" class="btn btn-sm btn-outline-primary mr-1" wire:click="edit({{ $category->id }})">Szerkesztés</button>
                  <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $category->id }})" wire:confirm="Biztosan törlöd ezt a kategóriát?">Törlés</button>
                @endif
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </main>
  </div>
</div>
