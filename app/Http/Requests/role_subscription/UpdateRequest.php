<?php

namespace App\Http\Requests\role_subscription;

use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

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
        if(!$this->isSubscriptionsExist()){$this->errorResponse(['user_id'=>['one of the combination of user_id and roles_id does not exist'],'roles_id'=>['one of the combination of roles_id and user_id does not exist']]);}
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
            'user_id'=>
            [
                'required',
                'exists:users,id',
                'numeric',
                'gte:1',
            ],
            'role_id'=>'required|exists:roles,id|numeric|gte:1', 
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }

    public function isSubscriptionsExist()
    {
        $query=DB::table('model_has_roles');
        $query->where('model_id',$this->user_id);
        $query->where('role_id',$this->role_id);
        return $query->exists();
    }
}
