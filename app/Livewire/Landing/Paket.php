<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Package;

class Paket extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public $type = '';

    public function setType($type)
    {
        $this->type = $type;
        $this->resetPage();
    }

    public function render()
    {
        $query = Package::where('is_active', true);

        if ($this->type === 'haji') {
            $query->where('title', 'like', '%haji%');
        } elseif ($this->type === 'umroh') {
            $query->where(function ($q) {
                $q->where('title', 'like', '%umrah%')
                  ->orWhere('title', 'like', '%umroh%');
            });
        }

        $packages = $query->latest()->paginate(6);
        
        $page_title = 'Daftar Paket Haji & Umroh';
        $meta_description = 'Pilihan paket haji dan umroh terbaik untuk menemani perjalanan ibadah Anda.';

        return view('livewire.landing.paket', compact('packages'))
            ->layout('landing.layouts.app', [
                'page_title' => $page_title,
                'meta_description' => $meta_description,
            ]);
    }
}
