<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Post;

class PostForm extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $modelId;
    public $featuredImage;

    protected $listeners = [
        'getModelId',
        'forcedCloseModal'
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Post::find($this->modelId);
        
        $this->title = $model->title;
        $this->content = $model->content;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:10|max:20',
            'content' => 'required',
            'featuredImage' => 'image' // Validates jpeg, png, gif and other image format
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->user()->id,
            'featured_image' => $this->featuredImage->hashName()
        ];
        
        if (!empty($this->featuredImage)) {
            $this->featuredImage->store('public/photos');
        }

        if ($this->modelId) {
            Post::find($this->modelId)->update($data);
        } else {            
            Post::create($data);
        }

        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
        $this->cleanVars();
    }

    public function forcedCloseModal()
    {
        // This is to reset our public variables
        $this->cleanVars();

        // These will reset our error bags
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function cleanVars()
    {
        $this->modelId = null;
        $this->title = null;
        $this->content = null;
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
