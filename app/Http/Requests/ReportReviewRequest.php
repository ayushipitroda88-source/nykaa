<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'reason' => 'required|in:spam,fake_review,abusive_language,misleading_information,other',
            'details' => 'nullable|string|max:1000',
        ];
    }
}
