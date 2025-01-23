<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $request         = $this->all();
        $request[ 'id' ] = $this->route('branch');
        return $this->replace($request);
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:branches,id',
        ];
    }
}
