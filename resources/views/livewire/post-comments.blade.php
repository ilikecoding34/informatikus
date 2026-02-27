<div id="comments" wire:poll.5s class="form-card">
    <div class="card-accent"></div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="mb-0">Hozzászólások</h5>
        <span class="text-muted small">{{ $totalCount ?? $comments->count() }} db</span>
    </div>

    @guest
        <div class="alert alert-info mb-3">
            Hozzászóláshoz jelentkezz be.
        </div>
    @endguest

    @auth
        <div class="mb-4">
            <form wire:submit.prevent="addComment">
                <div class="form-group">
                    <label for="newComment" class="font-weight-bold">Új hozzászólás</label>
                    <textarea id="newComment" class="form-control @error('newBody') is-invalid @enderror" rows="3"
                        wire:model.live="newBody" placeholder="Írd ide a hozzászólásod..."></textarea>
                    @error('newBody')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        Küldés
                    </button>
                </div>
            </form>
        </div>
    @endauth

    @if ($comments->isEmpty())
        <div class="text-muted">Még nincs hozzászólás.</div>
    @else
        <div>
            @foreach ($comments as $comment)
                @include('livewire.partials.comment-node', ['comment' => $comment, 'depth' => 0])
            @endforeach
        </div>
    @endif
</div>

