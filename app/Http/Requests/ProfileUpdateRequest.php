<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $this->user()->id,
            'password' => 'nullable|string|min:6|confirmed',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'avatar' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ];
    }
}
