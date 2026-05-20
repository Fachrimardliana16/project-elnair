<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_testimonials');
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'role_label' => 'required|string|max:255',
            'quote'      => 'required|string|max:2000',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'thumbnail'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'video_url'  => 'nullable|url|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Nama testimoniator wajib diisi.',
            'name.max'            => 'Nama maksimal 255 karakter.',
            'role_label.required' => 'Label peran (contoh: Jamaah Umroh 2024) wajib diisi.',
            'quote.required'      => 'Isi testimoni wajib diisi.',
            'quote.max'           => 'Testimoni maksimal 2000 karakter.',
            'avatar.image'        => 'Avatar harus berupa gambar.',
            'avatar.max'          => 'Ukuran avatar maksimal 1MB.',
            'thumbnail.image'     => 'Thumbnail harus berupa gambar.',
            'thumbnail.max'       => 'Ukuran thumbnail maksimal 1MB.',
            'video_url.url'       => 'URL video tidak valid.',
        ];
    }
}
