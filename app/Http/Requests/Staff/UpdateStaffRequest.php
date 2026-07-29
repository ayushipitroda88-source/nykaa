<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $adminId = $this->route('staff');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($adminId)],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
            'role_id' => ['sometimes', 'integer', 'exists:roles,id'],
            'status' => ['sometimes', 'boolean'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}