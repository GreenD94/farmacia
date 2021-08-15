<?php

namespace App\Http\Requests\product;

use App\Models\TagSubscription;
use App\Rules\ExistsPair;
use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

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
            'branch_office_id'=>  ['exists:branch_offices,id','numeric','gte:1'],
            'product_detail_id'=>  ['exists:product_details,id','numeric','gte:1'],
            'price'=>  [ 'numeric'],
            'show_price'=>  [ 'boolean'],
            'id'=>  ['required','exists:products,id','numeric','gte:1'],     
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }

}
