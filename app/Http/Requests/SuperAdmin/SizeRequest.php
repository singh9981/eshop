<?php

namespace App\Http\Requests\SuperAdmin;

use App\Models\Size;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $size = $this->route('size');

        $sizeId = $size instanceof Size
            ? $size->id
            : $size;

        return [
            'size_name' => [
                'required',
                'string',
                'max:100',
            ],

            'slug' => [
                'required',
                'string',
                'max:150',
                Rule::unique('sizes', 'slug')->ignore($sizeId),
            ],

            'size_type' => [
                'nullable',
                'string',
                Rule::in([
                    'clothing',
                    'shoes',
                    'numeric',
                    'custom',
                ]),
            ],

            'size_value' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'size_name.required' => 'Size name is required.',
            'slug.required' => 'Size slug is required.',
            'slug.unique' => 'This size slug already exists.',
            'size_type.in' => 'Please select a valid size type.',
            'status.required' => 'Please select size status.',
        ];
    }
}
