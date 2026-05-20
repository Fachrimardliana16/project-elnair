<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => 'required|string|max:255',
            'image'    => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul galeri wajib diisi.',
            'title.max'      => 'Judul maksimal 255 karakter.',
            'image.image'    => 'File harus berupa gambar.',
            'image.max'      => 'Ukuran gambar maksimal 2MB.',
            'category.max'   => 'Kategori maksimal 100 karakter.',
        ];
    }
}
