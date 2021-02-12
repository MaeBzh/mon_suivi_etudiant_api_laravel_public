<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'school.address.address1' => 'required|string',
            'school.address.address2' => 'nullable|string',
            'school.address.zipcode' => 'required|string',
            'school.address.city' => 'required|string',
            'address.address1' => 'required|string',
            'address.address2' => 'nullable|string',
            'address.zipcode' => 'required|string',
            'address.city' => 'required|string'
        ];
    }
}
