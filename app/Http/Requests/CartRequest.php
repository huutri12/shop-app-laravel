<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id'  => ['required', 'integer', 'exists:product,id'],
            'qty' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Thiếu sản phẩm cần mua.',
            'id.exists'   => 'Sản phẩm không tồn tại.',
            'qty.min'     => 'Số lượng phải >= 1.',
        ];
    }
}
