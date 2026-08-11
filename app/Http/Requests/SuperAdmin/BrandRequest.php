<?php

namespace App\Http\Requests\SuperAdmin
;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brand = $this->route('brand');

        $brandId = $brand instanceof Brand
            ? $brand->id
            : $brand;

        return [
            'brand_name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'slug')->ignore($brandId),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'logo' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,svg',
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
            'brand_name.required' => 'Brand name is required.',
            'slug.required' => 'Brand slug is required.',
            'slug.unique' => 'This brand slug already exists.',
            'logo.required' => 'Brand logo is required.',
            'logo.image' => 'Please upload a valid image.',
            'logo.mimes' => 'Logo must be JPG, JPEG, PNG, WebP or SVG.',
            'logo.max' => 'Logo size must not exceed 2 MB.',
            'status.required' => 'Please select brand status.',
        ];
    }
}
