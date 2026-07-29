<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:150',
            'description' => 'required|string|min:10|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Please select a star rating.',
            'rating.min' => 'Please select at least 1 star.',
            'description.required' => 'Please write your review.',
            'description.min' => 'Review must be at least 10 characters long.',
            'description.max' => 'Review cannot exceed 1000 characters.',
            'images.max' => 'You can upload a maximum of 5 images.',
            'images.*.image' => 'Uploaded files must be valid images.',
            'images.*.max' => 'Each image must not exceed 4MB.',
        ];
    }
}
