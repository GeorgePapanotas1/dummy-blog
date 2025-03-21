<?php

namespace App\Livewire\Partials;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;

class PostCard extends Component
{
    public Post $post;

    public function render(): View
    {
        return view('livewire.partials.post-card');
    }
}
