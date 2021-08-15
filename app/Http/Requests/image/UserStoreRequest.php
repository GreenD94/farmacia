<?php

namespace App\Http\Requests\image;

use App\Rules\ExistsPair;
use App\Rules\UniquePair;
use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
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
            'user_id'=>  ['required','exists:users,id','numeric','gte:1'],
            'role_id'=>  ['required', new ExistsPair('tags','type','user_image','id')],
            'image'=>  ['required','file','mimes:jpg,jpeg,png'],
            'path'=>  [ 'required'],
                ];
    } 
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }
}
