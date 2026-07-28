<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id
            ?? $this->route('category');
    
        return [
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                Rule::notIn([$categoryId]),
            ],

            'category_name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_id.exists' => 'Selected parent category is invalid.',
            'parent_id.not_in' => 'Category cannot be its own parent.',
            'category_name.required' => 'Category name is required.',
            'slug.required' => 'Category slug is required.',
            'slug.unique' => 'This slug already exists.',
            'image.mimes' => 'Only JPG, JPEG, PNG and WebP images are allowed.',
            'image.max' => 'Image size must not exceed 2 MB.',
        ];
    }
}