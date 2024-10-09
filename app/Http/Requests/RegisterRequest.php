<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        // Izinkan semua pengguna untuk mengakses request ini
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|min:5|max:20|alpha_num|unique:users,username',
            'password' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama diperlukan.',
            'email.required' => 'Email diperlukan.',
            'password.required' => 'Password diperlukan.',
        ];
    }
}
