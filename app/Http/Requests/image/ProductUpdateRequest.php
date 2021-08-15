<?php

namespace App\Http\Requests\image;

use App\Models\Image;
use App\Rules\ExistsPair;
use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
{
    use Responser;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //if(!$this->ajax()){$this->errorResponse(null,'only ajax is accepted',403);}
        if(!$this->isProductImage()){$this->errorResponse(['id'=>['invalid id: id does not belong to product images']]);}
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
            'role_id'=>  [ new ExistsPair('tags','type','product_image','id')],
            'image'=>  ['file','mimes:jpg,jpeg,png'],
            'path'=>  [ ],
            'id'=>  ['required','numeric','gte:1'],
            'name'=>  [ ],     
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }

    protected  function isProductImage()
    {
        return Image::where('id',$this->id)->SearchByRelationship('Tag','type','product_image')->exists();
    }
}
