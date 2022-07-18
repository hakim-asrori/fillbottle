<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if ($this->method() == 'PUT') {
            $password = 'nullable|min:8';
        } else {
            $password = 'required|min:8';
        }

        return [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'level' => 'required',
            'password' => $password
        ];
    }
}
