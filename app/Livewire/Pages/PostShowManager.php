<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;

class PostShowManager extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    public function render(): View
    {
        return view('livewire.pages.public.post-show-manager')
            ->with('commentsComponent', true)
            ->layout('components.layouts.index', ['title' => $this->post->title]);
    }
}
