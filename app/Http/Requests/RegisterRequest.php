<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.email' => 'required|unique:users,email|email',
            'user.password' => 'required_with:confirmPassword|string|min:8',
            'user.confirmPassword' => 'required|string|min:8',
            'user.firstname' => 'required|string',
            'user.lastname' => 'required|string',
            'user.phone' => 'required|string',
            'user.rememberMe' => 'required|boolean',
            'company.name' => 'required|string',
            'company.address.address1' => 'required|string',
            'company.address.address' => 'nullable|string',
            'company.address.zipcode' => 'required|numeric',
            'company.address.city' => 'required|string',
        ];
    }
}
