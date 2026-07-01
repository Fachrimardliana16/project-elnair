<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreHeroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_hero');
    }

    public function rules(): array
    {
        return [
            'tagline'              => 'nullable|string|max:255',
            'title'                => 'required|string|max:255',
            'subtitle'             => 'nullable|string|max:500',
            'btn_primary_text'     => 'nullable|string|max:100',
            'btn_primary_url'      => 'nullable|string|max:500',
            'btn_secondary_text'   => 'nullable|string|max:100',
            'btn_secondary_url'    => 'nullable|string|max:500',
            'background_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'background_image_2'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'background_image_3'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'          => 'Judul hero section wajib diisi.',
            'background_image.image'  => 'Background 1 harus berupa gambar.',
            'background_image.mimes'  => 'Format gambar 1 hanya JPG, JPEG, PNG, atau WebP.',
            'background_image.max'    => 'Ukuran gambar 1 maksimal 2MB.',
            'background_image_2.image'  => 'Background 2 harus berupa gambar.',
            'background_image_2.mimes'  => 'Format gambar 2 hanya JPG, JPEG, PNG, atau WebP.',
            'background_image_2.max'    => 'Ukuran gambar 2 maksimal 2MB.',
            'background_image_3.image'  => 'Background 3 harus berupa gambar.',
            'background_image_3.mimes'  => 'Format gambar 3 hanya JPG, JPEG, PNG, atau WebP.',
            'background_image_3.max'    => 'Ukuran gambar 3 maksimal 2MB.',
        ];
    }
}
