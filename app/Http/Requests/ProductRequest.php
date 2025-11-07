<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm bắt buộc nhập.',
            'price.numeric' => 'Giá sản phẩm phải là số.',
        ];
    }
}
