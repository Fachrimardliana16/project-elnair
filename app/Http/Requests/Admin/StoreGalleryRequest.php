<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => 'required|string|max:255',
            'image'    => 'required|image|max:2048',
            'category' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Judul galeri wajib diisi.',
            'title.max'       => 'Judul maksimal 255 karakter.',
            'image.required'  => 'Gambar wajib diunggah.',
            'image.image'     => 'File harus berupa gambar.',
            'image.max'       => 'Ukuran gambar maksimal 2MB.',
            'category.max'    => 'Kategori maksimal 100 karakter.',
        ];
    }
}
