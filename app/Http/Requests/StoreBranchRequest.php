<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];

        $rules = [
//            'name'        => 'required|string|max:255|unique:branches,name',
            'business_id' => [
                'required',
            ],
            'images'      => 'required',
        ];

        foreach( $days as $day )
        {
            // Add required validation for start and end time on 'Monday' (and others)
            $rules[ "$day.start_date.*" ] = $day === 'Monday' ? 'required_with:' . $day . '.end_date.*|date_format:H:i' : 'nullable|date_format:H:i';
            $rules[ "$day.end_date.*" ]   = $day === 'Monday' ? 'required_with:' . $day . '.start_date.*|date_format:H:i|after:' . $day . '.start_date.*' : 'nullable|date_format:H:i|after:' . $day . '.start_date.*';
        }

        return $rules;
    }
}
