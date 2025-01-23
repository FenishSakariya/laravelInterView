<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required|string|max:255|unique:businesses,name',
            'email' => [
                'required',
                'email',
                'unique:businesses,email',
                'regex:/^[\w\.-]+@[\w\.-]+\.\w{2,6}$/',
            ],
            'phone' => 'required|string|min:10|max:15',
            'logo'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
