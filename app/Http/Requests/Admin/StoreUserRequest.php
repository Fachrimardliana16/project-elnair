<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_users');
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles'    => 'required|array|min:1',
            'roles.*'  => 'string|exists:roles,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama pengguna wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.required'     => 'Pilih minimal satu role untuk pengguna.',
            'roles.*.exists'     => 'Role yang dipilih tidak valid.',
        ];
    }
}
