<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Managed by admin middleware
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
            'name.max'      => 'Nama maksimal 255 karakter.',
            'role.max'      => 'Jabatan/peran maksimal 255 karakter.',
            'image.image'   => 'File harus berupa gambar.',
            'image.mimes'   => 'Format gambar hanya JPG, JPEG, PNG, atau WebP.',
            'image.max'     => 'Ukuran gambar maksimal 2MB.',
            'order.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
