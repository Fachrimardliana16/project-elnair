<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'role'        => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'order'       => 'nullable|integer|min:0|max:999',
            'is_active'   => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pembimbing wajib diisi.',
            'image.image'   => 'File harus berupa gambar.',
            'image.mimes'   => 'Format gambar hanya JPG, JPEG, PNG, atau WebP.',
            'image.max'     => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
