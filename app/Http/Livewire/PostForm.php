<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Post;

class PostForm extends Component
{
    public $title;
    public $content;
    public $modelId;

    protected $listeners = [
        'getModelId'
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
            'content' => 'required'
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->user()->id,
        ];

        if ($this->modelId) {
            Post::find($this->modelId)->update($data);
        } else {            
            Post::create($data);
        }

        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
        $this->cleanVars();
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
