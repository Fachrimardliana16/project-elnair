<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_articles');
    }

    public function rules(): array
    {
        $articleId = $this->route('article')?->id ?? $this->route('article');

        return [
            'title'     => 'required|string|max:255|unique:articles,title,' . $articleId,
            'content'   => 'required|string|max:100000',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'    => 'required|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Judul artikel wajib diisi.',
            'title.max'        => 'Judul artikel maksimal 255 karakter.',
            'title.unique'     => 'Judul artikel sudah ada, gunakan judul yang berbeda.',
            'content.required' => 'Konten artikel wajib diisi.',
            'thumbnail.image'  => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes'  => 'Format thumbnail hanya boleh JPG, JPEG, PNG, atau WebP.',
            'thumbnail.max'    => 'Ukuran thumbnail maksimal 2MB.',
            'status.required'  => 'Status artikel wajib dipilih.',
            'status.in'        => 'Status hanya boleh draft atau published.',
        ];
    }
}
