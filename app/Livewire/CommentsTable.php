<?php

namespace App\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CommentsTable extends Component
{
    public $search = '';
    public $sortOrder = 'desc'; // 'asc' or 'desc' by created_at
    public $editingId = null;
    public $editBody = '';
    public $confirmingDelete = null;

    private function getSubtreeIds(int $commentId): array
    {
        $ids = [$commentId];
        $frontier = [$commentId];
        while (!empty($frontier)) {
            $children = Comment::whereIn('parent_id', $frontier)->pluck('id')->all();
            if (empty($children)) {
                break;
            }
            $ids = array_values(array_unique(array_merge($ids, $children)));
            $frontier = $children;
        }
        return $ids;
    }

    public function askDelete(int $id): void
    {
        $comment = Comment::where('user_id', Auth::id())->find($id);
        if ($comment) {
            $this->confirmingDelete = $id;
        }
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = null;
    }

    public function deleteComment(int $id): void
    {
        $comment = Comment::where('user_id', Auth::id())->find($id);
        if (!$comment) {
            return;
        }
        $ids = $this->getSubtreeIds($id);
        Comment::whereIn('id', $ids)->delete();
        $this->confirmingDelete = null;
    }

    public function hideComment(int $id): void
    {
        $comment = Comment::where('user_id', Auth::id())->find($id);
        if (!$comment) {
            return;
        }
        $ids = $this->getSubtreeIds($id);
        Comment::whereIn('id', $ids)->update(['hidden_at' => now()]);
        $this->editingId = null;
    }

    public function unhideComment(int $id): void
    {
        $comment = Comment::where('user_id', Auth::id())->find($id);
        if (!$comment) {
            return;
        }
        $ids = $this->getSubtreeIds($id);
        Comment::whereIn('id', $ids)->update(['hidden_at' => null]);
    }

    public function startEdit(int $id): void
    {
        $comment = Comment::where('user_id', Auth::id())->find($id);
        if (!$comment) {
            return;
        }
        $this->editingId = $id;
        $this->editBody = $comment->body;
        $this->resetErrorBag();
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editBody = '';
        $this->resetErrorBag();
    }

    public function saveEdit(int $id): void
    {
        $comment = Comment::where('user_id', Auth::id())->find($id);
        if (!$comment) {
            return;
        }
        $this->validate([
            'editBody' => ['required', 'string', 'min:2', 'max:3000'],
        ]);
        $comment->update(['body' => $this->editBody]);
        $this->editingId = null;
        $this->editBody = '';
        $this->resetErrorBag();
    }

    public function getCommentsProperty()
    {
        $query = Comment::query()
            ->where('user_id', Auth::id())
            ->with(['post', 'user'])
            ->orderBy('created_at', $this->sortOrder === 'asc' ? 'asc' : 'desc');

        if (strlen($this->search) >= 2) {
            $query->where(function ($q) {
                $q->where('body', 'like', '%' . $this->search . '%')
                    ->orWhereHas('post', function ($pq) {
                        $pq->where('title', 'like', '%' . $this->search . '%');
                    });
            });
        }

        return $query->get();
    }

    public function render()
    {
        return view('livewire.comments-table', [
            'comments' => $this->comments,
        ]);
    }
}
