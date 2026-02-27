<?php

namespace App\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

class PostComments extends Component
{
    #[Locked]
    public int $postId;

    public string $newBody = '';

    public ?int $replyingTo = null;
    public string $replyBody = '';
    public ?int $confirmingDelete = null;
    public ?int $editingId = null;
    public string $editBody = '';

    public function mount(int $postId): void
    {
        $this->postId = $postId;
    }

    public function startReply(int $commentId): void
    {
        $this->replyingTo = $commentId;
        $this->replyBody = '';
        $this->editingId = null;
        $this->editBody = '';
        $this->resetErrorBag();
    }

    public function cancelReply(): void
    {
        $this->replyingTo = null;
        $this->replyBody = '';
        $this->resetErrorBag();
    }

    public function startEdit(int $commentId): void
    {
        if (!Auth::check()) {
            return;
        }

        $comment = Comment::query()
            ->where('post_id', $this->postId)
            ->whereKey($commentId)
            ->first();

        if (!$comment || (int) $comment->user_id !== (int) Auth::id()) {
            return;
        }

        $this->editingId = $commentId;
        $this->editBody = (string) $comment->body;
        $this->replyingTo = null;
        $this->replyBody = '';
        $this->confirmingDelete = null;
        $this->resetErrorBag();
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editBody = '';
        $this->resetErrorBag();
    }

    public function saveEdit(int $commentId): void
    {
        if (!Auth::check()) {
            return;
        }

        if ($this->editingId !== $commentId) {
            return;
        }

        $data = $this->validate([
            'editBody' => ['required', 'string', 'min:2', 'max:3000'],
        ]);

        $comment = Comment::query()
            ->where('post_id', $this->postId)
            ->whereKey($commentId)
            ->first();

        if (!$comment || (int) $comment->user_id !== (int) Auth::id()) {
            return;
        }

        $comment->update(['body' => $data['editBody']]);

        $this->editingId = null;
        $this->editBody = '';
        $this->resetErrorBag();
    }

    public function askDelete(int $commentId): void
    {
        $this->confirmingDelete = $commentId;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = null;
    }

    public function addComment(): void
    {
        if (!Auth::check()) {
            return;
        }

        $data = $this->validate([
            'newBody' => ['required', 'string', 'min:2', 'max:3000'],
        ]);

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'body' => $data['newBody'],
            'parent_id' => null,
        ]);

        $this->newBody = '';
        $this->resetErrorBag();
    }

    public function addReply(int $parentId): void
    {
        if (!Auth::check()) {
            return;
        }

        // ensure parent belongs to this post
        $parent = Comment::query()
            ->where('post_id', $this->postId)
            ->whereKey($parentId)
            ->first();

        if (!$parent) {
            return;
        }

        $data = $this->validate([
            'replyBody' => ['required', 'string', 'min:2', 'max:3000'],
        ]);

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'body' => $data['replyBody'],
            'parent_id' => $parentId,
        ]);

        $this->replyingTo = null;
        $this->replyBody = '';
        $this->resetErrorBag();
    }

    public function deleteComment(int $commentId): void
    {
        if (!Auth::check()) {
            return;
        }

        $comment = Comment::query()
            ->where('post_id', $this->postId)
            ->whereKey($commentId)
            ->first();

        if (!$comment || (int) $comment->user_id !== (int) Auth::id()) {
            return;
        }

        $idsToDelete = [$comment->id];
        $frontier = [$comment->id];

        // Delete the entire subtree (any depth)
        while (!empty($frontier)) {
            $children = Comment::query()
                ->where('post_id', $this->postId)
                ->whereIn('parent_id', $frontier)
                ->pluck('id')
                ->all();

            if (empty($children)) {
                break;
            }

            $idsToDelete = array_values(array_unique(array_merge($idsToDelete, $children)));
            $frontier = $children;
        }

        Comment::query()
            ->where('post_id', $this->postId)
            ->whereIn('id', $idsToDelete)
            ->delete();

        $this->confirmingDelete = null;
    }

    public function hideComment(int $commentId): void
    {
        if (!Auth::check()) {
            return;
        }

        $comment = Comment::query()
            ->where('post_id', $this->postId)
            ->whereKey($commentId)
            ->first();

        if (!$comment || (int) $comment->user_id !== (int) Auth::id()) {
            return;
        }

        $idsToHide = [$comment->id];
        $frontier = [$comment->id];
        while (!empty($frontier)) {
            $children = Comment::query()
                ->whereIn('parent_id', $frontier)
                ->pluck('id')
                ->all();
            if (empty($children)) {
                break;
            }
            $idsToHide = array_values(array_unique(array_merge($idsToHide, $children)));
            $frontier = $children;
        }

        Comment::query()->whereIn('id', $idsToHide)->update(['hidden_at' => now()]);
    }

    private function buildTree($all)
    {
        $byId = $all->keyBy('id');

        foreach ($all as $comment) {
            $comment->setRelation('children', collect());
        }

        foreach ($all as $comment) {
            if ($comment->parent_id && $byId->has($comment->parent_id)) {
                $byId[$comment->parent_id]->children->push($comment);
            }
        }

        $roots = $all->whereNull('parent_id')->sortByDesc('id')->values();

        return [$roots, $all->count()];
    }

    public function render()
    {
        $all = Comment::query()
            ->where('post_id', $this->postId)
            ->visible()
            ->with('user')
            ->orderBy('id')
            ->get();

        [$roots, $totalCount] = $this->buildTree($all);

        return view('livewire.post-comments', [
            'comments' => $roots,
            'totalCount' => $totalCount,
        ]);
    }
}

