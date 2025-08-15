<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostList extends Component
{
    public function render()
    {
        $posts = Post::select('id', 'title', 'created_at')->paginate(10);
        return view('livewire.post-list', compact('posts'));
    }
}
