<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLandingPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'                   => 'required|string|max:255',
            'slug'                    => 'nullable|string|max:255|unique:landing_pages,slug|regex:/^[a-z0-9\-]+$/',
            'custom_domain'           => 'nullable|string|max:255|unique:landing_pages,custom_domain',
            'content'                 => 'nullable|string|max:200000',
            'custom_wa_number'        => 'nullable|string|max:255',
            'custom_wa_message'       => 'nullable|string|max:1000',
            'hero_image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'              => 'nullable|string|max:255',
            'meta_description'        => 'nullable|string|max:500',
            'pixel_script'            => 'nullable|string|max:10000',
            'fb_pixel_id'             => 'nullable|string|max:100',
            'fb_capi_token'           => 'nullable|string|max:500',
            'tiktok_pixel_id'         => 'nullable|string|max:100',
            'tiktok_capi_token'       => 'nullable|string|max:500',
            'snack_pixel_id'          => 'nullable|string|max:100',
            'google_pixel_id'         => 'nullable|string|max:100',
            'google_conversion_label' => 'nullable|string|max:100',
            'ad_event_name'           => 'nullable|string|max:100',
            'fb_pixel_events'         => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'Judul landing page wajib diisi.',
            'slug.unique'        => 'Slug sudah digunakan, pilih slug yang berbeda.',
            'slug.regex'         => 'Slug hanya boleh mengandung huruf kecil, angka, dan tanda hubung (-).',
            'custom_domain.unique' => 'Domain khusus sudah digunakan.',
            'hero_image.image'   => 'Hero image harus berupa gambar.',
            'hero_image.mimes'   => 'Format hero image hanya JPG, JPEG, PNG, atau WebP.',
            'hero_image.max'     => 'Ukuran hero image maksimal 2MB.',
        ];
    }
}
