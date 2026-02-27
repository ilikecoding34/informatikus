<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Tagek</div>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
          {{ session('message') }}
        </div>
      @endif

      {{-- Create form --}}
      <div class="form-card mb-4">
        <div class="card-accent"></div>
        <h5 class="mb-3">Új tag</h5>
        <form wire:submit="save">
          <div class="form-group mb-2">
            <label for="name">Tag név</label>
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
        <h5 class="mb-3">Tagek</h5>
        @if ($tags->isEmpty())
          <p class="text-muted mb-0">Még nincs tag. Hozz létre egyet fent.</p>
        @else
          <div class="list-group list-group-flush">
            @foreach ($tags as $tag)
              <div class="list-group-item px-0">
                @if ($editId === $tag->id)
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
                  <span class="mr-2 font-weight-bold">{{ $tag->name }}</span>
                  <span class="text-muted small mr-2">{{ $tag->posts_count }} bejegyzés</span>
                  <a href="{{ url('/category/' . $tag->name) }}" class="btn btn-sm btn-outline-secondary mr-1" target="_blank">Megtekintés</a>
                  <button type="button" class="btn btn-sm btn-outline-primary mr-1" wire:click="edit({{ $tag->id }})">Szerkesztés</button>
                  <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $tag->id }})" wire:confirm="Biztosan törlöd ezt a taget?">Törlés</button>
                @endif
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </main>
  </div>
</div>
