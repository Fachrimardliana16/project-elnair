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
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'          => 'Judul hero section wajib diisi.',
            'background_image.image'  => 'Background harus berupa gambar.',
            'background_image.mimes'  => 'Format gambar hanya JPG, JPEG, PNG, atau WebP.',
            'background_image.max'    => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
