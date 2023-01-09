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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();
        if ($method == "POST") {
            return [
                //
                'name' => 'required|between:2,100',
                'email' => 'required|email|max:100|unique:users',
                'password' => 'required|min:6'
            ];
        }
    }
    public function  messages()
    {
        return [
            'name.required' => 'The name input field is not allowed blank',
            'name.between' => 'The length of name is betwen 2 untul 100',
            'email.required' => 'The email input field is not allowed blank',
            'email.email' => 'The email is not valid',
            'email.max' => 'The length of email may not be longer than 100 characters',
            'email.unique' => 'The email has been registered',
            'password.required' => 'The password input field is not allowed blank',
            'password.min' => 'The length of password may not be less than 6 characters'
        ];
    }
}
