<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:blog,slug'],
            'description' => ['nullable', 'string'],
            'content'     => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'author'      => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập Title.',
            'description.required' => 'Vui lòng nhập description.',
            'image.image'  => 'Image phải là hình ảnh.',
            'image.max'    => 'Image tối đa 1MB.',
        ];
    }
}
