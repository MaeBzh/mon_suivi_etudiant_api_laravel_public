<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
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
            'filename' => 'sometimes|string',
            'relative_path' => 'sometimes|string',
            'extension' => 'sometimes|string',
            'disk' => 'sometimes|string',
            'debrief' => 'sometimes|numeric',
            'student' => 'sometimes|numeric',
            'document_type' => 'sometimes|numeric'
        ];
    }
}
