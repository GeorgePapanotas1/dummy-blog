<?php

namespace App\Livewire\Partials;

use App\Dto\Posts\Forms\CreateCommentForm;
use App\Exceptions\Posts\CommentNotCreatedException;
use App\Models\Post;
use App\Services\Posts\CommentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class PostComments extends Component
{
    public Post $post;

    public $content = '';

    private readonly CommentService $commentService;

    public function boot(CommentService $commentService): void
    {
        $this->commentService = $commentService;
    }

    protected $rules = [
        'content' => 'required|string|max:500',
    ];

    public function addComment(): void
    {
        if (! Auth::check()) {
            return;
        }

        $this->validate([
            'content' => ['required', 'string', 'max:255'],
        ]);

        try {
            $this->commentService->create(new CreateCommentForm(
                $this->post->id,
                auth()->id(),
                $this->content
            ));
        } catch (CommentNotCreatedException $e) {
            session()->flash('fail', 'Could not create comment.');
        } catch (\Throwable $e) {
            session()->flash('fail', $e->getMessage());
        }

        $this->reset('content');
    }

    public function render(): View
    {
        return view('livewire.partials.post-comments', [
            'comments' => $this->post->comments()->latest()->get(),
        ]);
    }
}
