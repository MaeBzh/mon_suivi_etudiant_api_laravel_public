<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ScorecardUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isTutor();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'skills' => 'sometimes',
            'student_id' => 'sometimes|numeric',
            'creator_id' => 'sometimes|numeric',
            'diploma_id' => 'sometimes|numeric'
        ];
    }
}
