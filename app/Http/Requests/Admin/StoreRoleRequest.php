<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:100|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Nama role wajib diisi.',
            'name.unique'          => 'Nama role sudah digunakan.',
            'name.max'             => 'Nama role maksimal 100 karakter.',
            'permissions.required' => 'Pilih minimal satu permission.',
            'permissions.array'    => 'Format permissions tidak valid.',
            'permissions.*.exists' => 'Permission tidak ditemukan.',
        ];
    }
}
