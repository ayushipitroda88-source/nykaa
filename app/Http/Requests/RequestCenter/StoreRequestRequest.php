<?php

namespace App\Http\Requests\RequestCenter;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('seller')->check();
    }

    public function rules(): array
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'request_type' => 'required|in:product_edit,product_delete,variant_edit,variant_delete',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ];

        if ($this->input('request_type') === 'product_edit') {
            $rules['product_title'] = 'required|string|max:255';
            $rules['product_description'] = 'required|string';
            $rules['category_id'] = 'required|exists:categories,id';
        }

        if (in_array($this->input('request_type'), ['variant_edit', 'variant_delete'])) {
            $rules['variant_id'] = 'required|exists:product_variants,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'request_type.required' => 'Please select a request type.',
            'request_type.in' => 'Invalid request type selected.',
            'reason.required' => 'Please provide a reason for this request.',
            'product_title.required' => 'Product title is required for edit requests.',
            'product_description.required' => 'Product description is required for edit requests.',
            'category_id.required' => 'Please select a category.',
            'variant_id.required' => 'Variant is required.',
            'attachment.max' => 'Attachment must not exceed 5MB.',
        ];
    }
}