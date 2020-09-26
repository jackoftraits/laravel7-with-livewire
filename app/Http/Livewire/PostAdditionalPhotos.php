<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\AdditionalPhotos;

class PostAdditionalPhotos extends Component
{
    public $postId;

    protected $listeners = [
        'getPostId',
    ];

    public function getPostId($postId)
    {
        $this->postId = $postId;
    }

    public function render()
    {
        return view('livewire.post-additional-photos', [
            'additionalPhotos' => AdditionalPhotos::where('post_id', '=', $this->postId)->get()
        ]);
    }
}
