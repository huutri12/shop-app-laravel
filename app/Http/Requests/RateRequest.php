<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_blog' => 'required|integer|exists:blog,id',
            'rate'    => 'required|integer|min:1|max:5'
        ];
    }
    public function messages()
    {
        return [
            'id_blog.required' => 'Thiếu thông tin bài viết',
            'id_blog.exists'   => 'Bài viết không tồn tại',
            'rate.min'         => 'Điểm đánh giá phải từ 1 trở lên',
            'rate.max'         => 'Điểm đánh giá phải không lớn hơn 5'
        ];
    }
}
