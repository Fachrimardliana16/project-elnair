<?php

namespace App\Livewire\Landing;

use App\Models\GalleryFolder;
use App\Models\GalleryItem;
use Livewire\Component;

class GallerySection extends Component
{
    public int $activeFolderId = 0;

    public function mount()
    {
        $first = GalleryFolder::latest('id')->first();
        if ($first) {
            $this->activeFolderId = $first->id;
        }
    }

    public function setActiveFolder(int $id)
    {
        $this->activeFolderId = $id;
    }

    public function render()
    {
        $folders = GalleryFolder::latest('id')->limit(3)->get();

        $items = collect();
        if ($this->activeFolderId) {
            $items = GalleryItem::where('gallery_folder_id', $this->activeFolderId)
                ->latest()
                ->take(6)
                ->get();
        }

        return view('livewire.landing.gallery-section', compact('folders', 'items'));
    }
}
