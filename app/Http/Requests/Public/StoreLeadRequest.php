<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'phone'         => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\s\(\)]{7,20}$/'],
            'package'       => 'nullable|string|max:255',
            'lead_event_id' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'name.max'       => 'Nama maksimal 255 karakter.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.max'      => 'Nomor telepon maksimal 20 karakter.',
            'phone.regex'    => 'Format nomor WhatsApp tidak valid.',
        ];
    }
}
