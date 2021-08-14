<?php

namespace App\Http\Requests\office_subscription;

use App\Rules\UniquePair;
use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'branch_office_id'=>
            [
                'required',
                'exists:branch_offices,id',
                'numeric',
                'gte:1',
                new UniquePair('office_subscriptions','user_id',$this->user_id)
            ],
            'user_id'=>
            [
                'required',
                'exists:users,id',
                'numeric',
                'gte:1',
                new UniquePair('office_subscriptions','branch_office_id',$this->user_id)
            ],
            'active'=>
            [
                'boolean'
            ],
            'status_id'=>
            [
                'required',
                'exists:tags,id',
                'numeric',
                'gte:1',
            ],
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }
}
