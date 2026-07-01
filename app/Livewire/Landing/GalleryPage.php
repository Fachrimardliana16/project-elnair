<?php

namespace App\Livewire\Landing;

use App\Models\GalleryFolder;
use App\Models\GalleryItem;
use Livewire\Component;
use Livewire\WithPagination;

class GalleryPage extends Component
{
    use WithPagination;

    public int $activeFolderId = 0;

    public function mount()
    {
        $first = GalleryFolder::oldest('id')->first();
        if ($first) {
            $this->activeFolderId = $first->id;
        }
    }

    public function setActiveFolder(int $id)
    {
        $this->activeFolderId = $id;
        $this->resetPage();
    }

    public function render()
    {
        $folders = GalleryFolder::oldest('id')->get();

        $query = GalleryItem::query()->latest();
        if ($this->activeFolderId) {
            $query->where('gallery_folder_id', $this->activeFolderId);
        }
        $items = $query->paginate(12);

        $page_title = 'Galeri Foto';
        $meta_description = 'Kumpulan foto dokumentasi perjalanan haji dan umroh kami.';

        return view('livewire.landing.gallery-page', compact('folders', 'items'))
            ->layout('landing.layouts.app', [
                'page_title' => $page_title,
                'meta_description' => $meta_description,
            ]);
    }
}
