<?php

namespace App\Http\Requests\category_subscription;

use App\Models\Image;
use App\Models\TagSubscription;
use App\Rules\ExistsPair;
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
        if(!$this->isProductCategory()){$this->errorResponse(['id'=>['invalid id: id does not belong to product category']]);}
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
            'product_id'=>  ['exists:products,id','numeric','gte:1'],
            'category_id'=>  [ new ExistsPair('tags','type','product_category','id')],
            'id'=>  ['required','numeric','gte:1'],
   
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }

    protected  function isProductCategory()
    {
        return TagSubscription::where('id',$this->id)->SearchByRelationship('Tag','type','product_category')->exists();
    }
}
