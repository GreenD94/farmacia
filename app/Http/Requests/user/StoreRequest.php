<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
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
            'password'              =>  'required|min:8',
            'email'                 =>  'required|email|unique:users,email',
            'first_name'                 =>  'required',
            'last_name'                 =>  'required',
            'phone'                 =>  'required',
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
