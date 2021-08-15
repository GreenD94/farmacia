<?php

namespace App\Http\Requests\address;

use App\Models\Image;
use App\Models\TagSubscription;
use App\Rules\ExistsPair;
use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OfficeUpdateRequest extends FormRequest
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
            'state_id'=>  ['exists:states,id ','numeric','gte:1'],
            'adress'=>  [ ],
            'latitude'=>  [ 'numeric'],
            'longitude'=>  [ 'numeric'],
            'active'=>  [ 'boolean'],
            'id'=>  ['required','exists:addresses,id','numeric','gte:1'],  
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }


}
