<?php

namespace App\Http\Requests\product;

use App\Rules\ExistsPair;
use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreRequest extends FormRequest
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
            'branch_office_id'=>  ['required','exists:branch_offices,id','numeric','gte:1'],
            'product_detail_id'=>  ['required','exists:product_details,id','numeric','gte:1'],
            'price'=>  ['required', 'numeric'],
            'show_price'=>  [ 'required','boolean'],
            'available'=>  [ 'required','boolean'],
        ];
    } 
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }
}
