<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class DocumentStoreRequest extends FormRequest
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
            'filename' => 'required|string',
            'relative_path' => 'required|string',
            'disk' => 'required|string',
            'document_type' => 'required|numeric',
            'debrief' => 'sometimes|numeric',
            'student' => 'required|numeric'
        ];
    }
}
