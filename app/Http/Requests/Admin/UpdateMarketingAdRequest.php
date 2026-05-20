<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketingAdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'link'      => 'required|url|max:500',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'Judul iklan wajib diisi.',
            'title.max'          => 'Judul maksimal 255 karakter.',
            'image.image'        => 'File harus berupa gambar.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
            'link.required'      => 'URL tujuan wajib diisi.',
            'link.url'           => 'URL tujuan tidak valid.',
            'link.max'           => 'URL tujuan maksimal 500 karakter.',
            'is_active.required' => 'Status aktif wajib dipilih.',
            'is_active.boolean'  => 'Status aktif tidak valid.',
        ];
    }
}
