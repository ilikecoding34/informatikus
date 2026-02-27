@php
    $safeDepth = min((int) ($depth ?? 0), 8);
    $indentPx = $safeDepth * 18;
@endphp

<div class="card mb-2" style="margin-left: {{ $indentPx }}px;">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1">
                <div class="mb-1">
                    <span class="font-weight-bold">{{ $comment->user->name ?? 'Ismeretlen' }}</span>
                    <span class="text-muted small ml-2">{{ $comment->updated_at?->diffForHumans() }}</span>
                </div>
                @if ($editingId === $comment->id)
                    <form wire:submit.prevent="saveEdit({{ $comment->id }})">
                        <div class="form-group mb-2">
                            <textarea class="form-control @error('editBody') is-invalid @enderror" rows="2"
                                wire:model.live="editBody"></textarea>
                            @error('editBody')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                wire:click="cancelEdit">
                                Mégse
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                style="margin-left: 8px;"
                                wire:loading.attr="disabled">
                                Mentés
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-body">{{ $comment->body }}</div>
                @endif
            </div>

            <div class="d-flex align-items-start">
                @auth
                    <button type="button" class="btn btn-sm btn-outline-secondary mr-2"
                        wire:click="startReply({{ $comment->id }})">
                        Válasz
                    </button>
                @endauth

                @auth
                    @if ((int) auth()->id() === (int) $comment->user_id)
                        @if ($editingId !== $comment->id && $replyingTo !== $comment->id)
                            <button type="button" class="btn btn-sm btn-outline-primary mr-2"
                                wire:click="startEdit({{ $comment->id }})">
                                Szerkesztés
                            </button>
                        @endif

                        @if ($confirmingDelete === $comment->id)
                            <button type="button" class="btn btn-sm btn-danger mr-2"
                                wire:click="deleteComment({{ $comment->id }})">
                                Igen
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                wire:click="cancelDelete">
                                Mégse
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-info mr-2"
                                wire:click="hideComment({{ $comment->id }})"
                                title="Rejtés (válaszokkal együtt)">
                                Rejtés
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                wire:click="askDelete({{ $comment->id }})"
                                title="Végleges törlés (válaszokkal együtt)">
                                Törlés
                            </button>
                        @endif
                    @endif
                @endauth
            </div>
        </div>

        @auth
            @if ($replyingTo === $comment->id)
                <div class="mt-3 p-3 rounded border bg-light">
                    <form wire:submit.prevent="addReply({{ $comment->id }})">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold mb-1">Válasz</label>
                            <textarea class="form-control @error('replyBody') is-invalid @enderror" rows="2"
                                wire:model.live="replyBody" placeholder="Írd ide a válaszod..."></textarea>
                            @error('replyBody')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                wire:click="cancelReply">
                                Mégse
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                style="margin-left: 8px;"
                                wire:loading.attr="disabled">
                                Küldés
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        @endauth

        @if ($comment->children->isNotEmpty())
            <div class="mt-3">
                @foreach ($comment->children->sortBy('id') as $child)
                    @include('livewire.partials.comment-node', ['comment' => $child, 'depth' => $safeDepth + 1])
                @endforeach
            </div>
        @endif
    </div>
</div>

