<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('seller')->check();
    }

    public function rules(): array
    {
        return [
            'reply' => 'required|string|min:5|max:1500',
        ];
    }
}
