<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            $foto = 'image|mimes:jpeg,png,jpg,gif|max:4096';
        } else {
            $password = 'required|min:8';
            $foto = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
        }

        return [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => $password,
            'foto' => $foto,
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kodepos' => 'required',
            'telp' => 'required'

        ];
    }
}
