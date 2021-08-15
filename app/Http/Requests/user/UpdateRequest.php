<?php

namespace App\Http\Requests\user;

use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use Responser;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!$this->ajax()){$this->errorResponse(null,'only ajax is accepted',403);}
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
            'password'              =>  'min:8',
            'email'                 =>  'email|unique:users,email',
            'id'                 =>  'required|exists:users,id|numeric|gte:1',            
            'birth_date'                 =>  'date', 
            'first_name'                 =>  [], 
            'last_name'                 =>  [], 
            'phone'                 =>  [], 
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }
}
