<?php
namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PostForm extends Component
{
    #[Validate('required|min:5')]
    public $title;

    #[Validate('required')]
    public $description;

    public $isView = false;
    public $postId;

    /**
     * Save post
     */
    public function savePost()
    {
        $validatedFormData = $this->validate();

        Post::create($validatedFormData);

        $this->reset();

        $this->dispatch('clear-quill');
    }

    public function render()
    {
        return view('livewire.post-form');
    }

    /**
     * Mount
     */
    public function mount($mode = null, $id = null)
    {
        if ($id) {

            $post = Post::findOrFail($id);

            $this->isView = $mode === 'view';

            $this->postId      = $post->id;
            $this->title       = $post->title;
            $this->description = $post->description;

            ## Event for populating data into the quill editor
            $this->dispatch('populate-quill', description: $this->description);
        }
    }

}
