<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Post;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;
    public $action;
    public $selectedItem;


    protected $listeners = [
        'refreshParent' => '$refresh'
    ];

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        
        if ($action == 'delete') {
            // This will show the modal on the frontend
            $this->dispatchBrowserEvent('openDeleteModal');
        } elseif ($action == 'showPhotos') {
            // Pass the currently selected item
            $this->emit('getPostId', $this->selectedItem);

            // Show the modal that shows the additional photos
            $this->dispatchBrowserEvent('openModalShowPhotos');
        }
        else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModal');
        }
    }

    public function delete()
    {
        Post::destroy($this->selectedItem);
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    public function render()
    {
        return view('livewire.posts', [
            'posts' => Post::where('user_id', '=', auth()->user()->id)->paginate(5)
        ]);
    }
}
