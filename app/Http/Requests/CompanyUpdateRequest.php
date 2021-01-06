<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'logo' => 'sometimes',
            'address.address1' => 'sometimes|string',
            'address.address2' => 'sometimes|nullable|string',
            'address.zipcode' => 'sometimes|string',
            'address.city' => 'sometimes|string',
        ];
    }
}
