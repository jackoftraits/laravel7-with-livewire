<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Post;
use Intervention\Image\ImageManager;

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
        // Data validation
        $validateData = [
            'title' => 'required|min:10|max:20',
            'content' => 'required',
        ];

        // Default data
        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->user()->id,
        ];

        if (!empty($this->featuredImage)) {
            $imageHashName = $this->featuredImage->hashName();

            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'featuredImage' => 'image'
            ]);
            
            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'featured_image' => $imageHashName
            ]);
            
            // Upload the main image
            $this->featuredImage->store('public/photos');

            // Create a thumbnail of the image using Intervention Image Library
            $manager = new ImageManager();
            $image = $manager->make('storage/photos/'.$imageHashName)->resize(300, 200);
            $image->save('storage/photos_thumb/'.$imageHashName);
        }

        $this->validate($validateData);

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
        $this->featuredImage = null;
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
