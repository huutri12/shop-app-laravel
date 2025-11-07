<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email'],
            'phone'      => ['nullable', 'string', 'max:50'],
            'address'    => ['nullable', 'string', 'max:255'],
            'id_country' => ['nullable', 'integer', 'exists:countries,id'],
            'password'   => ['nullable', 'string', 'min:8'],
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1024'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập username.',
            'email.required' => 'Vui lòng nhập email.',
            'avatar.image'  => 'Avatar phải là hình ảnh.',
            'avatar.max'    => 'Avatar tối đa 1MB.',
        ];
    }
}
