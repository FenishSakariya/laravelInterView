<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $request         = $this->all();
        $request[ 'id' ] = $this->route('business');
        return $this->replace($request);
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:businesses,id',
        ];
    }
}
