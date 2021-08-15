<?php

namespace App\Http\Requests\product;

use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class DetailUpdateRequest extends FormRequest
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
        return 
        [
            'name'                 =>  [],
            'description'                 =>  [],
            'id'                 =>  'required|exists:product_details,id|numeric|gte:1', 
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }
}
