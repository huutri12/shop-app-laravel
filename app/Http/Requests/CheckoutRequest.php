<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
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
        // Nếu user đã login
        if (Auth::check()) {
            return [
                'phone'   => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'note'    => 'nullable|string|max:1000',
            ];
        }

        // Nếu user chưa đăng nhập → đăng ký nhanh
        return [
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',

            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',

            'phone.required' => 'Vui lòng nhập số điện thoại',
            'address.required' => 'Vui lòng nhập địa chỉ giao hàng',
        ];
    }
}
