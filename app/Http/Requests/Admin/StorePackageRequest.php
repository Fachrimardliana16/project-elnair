<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_packages');
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'price_label'  => 'required|string|max:50',
            'price_value'  => 'required|string|max:100',
            'description'  => 'required|string|max:5000',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'itinerary'    => 'nullable|string|max:10000',
            'hotel_makkah' => 'nullable|string|max:255',
            'hotel_madinah'=> 'nullable|string|max:255',
            'maskapai'     => 'nullable|string|max:255',
            'fasilitas'    => 'nullable|string|max:5000',
            'is_active'    => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Judul paket wajib diisi.',
            'title.max'            => 'Judul paket maksimal 255 karakter.',
            'price_label.required' => 'Label harga wajib diisi (contoh: IDR).',
            'price_value.required' => 'Nilai harga wajib diisi (contoh: 350jt).',
            'description.required' => 'Deskripsi paket wajib diisi.',
            'description.max'      => 'Deskripsi maksimal 5000 karakter.',
            'image.required'       => 'Gambar paket wajib diunggah.',
            'image.image'          => 'File harus berupa gambar (JPG, PNG, atau WebP).',
            'image.mimes'          => 'Format gambar hanya boleh JPG, JPEG, PNG, atau WebP.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
