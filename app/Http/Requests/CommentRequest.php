<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'id_blog' => ['required', 'integer', 'exists:blog,id'],
            'content' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id']

        ];
    }

    public function messages(): array
    {
        return [
            'id_blog.required' => 'Thiếu thông tin bài viết.',
            'id_blog.exists'   => 'Bài viết không tồn tại.',
            'content.required' => 'Bạn chưa nhập nội dung bình luận.',
            'content.max'      => 'Bình luận tối đa 1000 ký tự.',
            'parent_id.exists' => 'Bình luận bạn trả lời không tồn tại.',
        ];
    }
}
