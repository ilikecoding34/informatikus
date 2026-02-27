<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Hozzászólásaim</div>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      <div class="form-card">
        <div class="card-accent"></div>
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
          <h5 class="mb-0">Hozzászólások</h5>
          <div class="d-flex align-items-center">
            <select class="form-control form-control-sm mr-2" wire:model.live="sortOrder" style="min-width: 160px;">
              <option value="desc">Legújabb először</option>
              <option value="asc">Legrégebbi először</option>
            </select>
            <input type="text" class="form-control form-control-sm" placeholder="Keresés…" wire:model.live.debounce.300ms="search" style="min-width: 180px;">
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-sm mb-0">
            <thead class="thead-light">
              <tr>
                <th>Bejegyzés</th>
                <th>Hozzászólás</th>
                <th>Szerző</th>
                <th>Státusz</th>
                <th>Frissítve</th>
                <th class="text-right">Művelet</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($comments as $item)
                <tr>
                  <td>
                    @if ($item->post)
                      <a href="{{ route('singlePost', $item->post_id) }}">{{ Str::limit($item->post->title, 40) }}</a>
                    @else
                      <span class="text-muted">Törölt bejegyzés</span>
                    @endif
                  </td>
                  <td>
                    @if ($editingId === $item->id)
                      <textarea class="form-control form-control-sm @error('editBody') is-invalid @enderror" rows="2" wire:model="editBody"></textarea>
                      @error('editBody')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                      @enderror
                    @else
                      {{ Str::limit($item->body, 60) }}
                    @endif
                  </td>
                  <td><small>{{ $item->user->name ?? '–' }}</small></td>
                  <td>
                    @if ($item->hidden_at)
                      <span class="badge badge-secondary">Rejtett</span>
                    @else
                      <span class="badge badge-success">Látható</span>
                    @endif
                  </td>
                  <td><small class="text-muted">@include('partials.time-ago', ['datetime' => $item->updated_at])</small></td>
                  <td class="text-right">
                    @if ($editingId === $item->id)
                      <button type="button" class="btn btn-sm btn-primary" wire:click="saveEdit({{ $item->id }})" wire:loading.attr="disabled">Mentés</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="cancelEdit">Mégse</button>
                    @else
                      <button type="button" class="btn btn-sm btn-outline-primary mr-1" wire:click="startEdit({{ $item->id }})">Szerkesztés</button>
                      @if ($item->hidden_at)
                        <button type="button" class="btn btn-sm btn-outline-success mr-1" wire:click="unhideComment({{ $item->id }})">Megjelenítés</button>
                      @else
                        <button type="button" class="btn btn-sm btn-outline-info mr-1" wire:click="hideComment({{ $item->id }})" title="Rejtés (válaszokkal együtt)">Rejtés</button>
                        @if ($confirmingDelete === $item->id)
                          <button type="button" class="btn btn-sm btn-danger mr-1" wire:click="deleteComment({{ $item->id }})">Igen, törlöm</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="cancelDelete">Mégse</button>
                        @else
                          <button type="button" class="btn btn-sm btn-outline-danger" wire:click="askDelete({{ $item->id }})" title="Végleges törlés (válaszokkal együtt)">Törlés</button>
                        @endif
                      @endif
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">Nincs megjeleníthető hozzászólás.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>
