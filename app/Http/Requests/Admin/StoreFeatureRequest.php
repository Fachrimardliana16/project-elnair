<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_features');
    }

    public function rules(): array
    {
        return [
            'icon'        => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'order'       => 'nullable|integer|min:0|max:999',
        ];
    }

    public function messages(): array
    {
        return [
            'icon.required'        => 'Ikon wajib diisi (contoh: fas fa-star).',
            'title.required'       => 'Judul fitur wajib diisi.',
            'description.required' => 'Deskripsi fitur wajib diisi.',
            'description.max'      => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}
