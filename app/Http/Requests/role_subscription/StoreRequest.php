<?php

namespace App\Http\Requests\role_subscription;


use App\Traits\Responser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;

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
        if(!$this->isSubscriptionsUnique()){$this->errorResponse(['user_id'=>['one of the combination of user_id and roles_id does not exist'],'roles_id'=>['one of the combination of roles_id and user_id does not exist']]);}
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
            'user_id'=>
            [
                'required',
                'exists:users,id',
                'numeric',
                'gte:1',
            ],
            'roles_id.*'=>'required|exists:roles,id|numeric|gte:1',
            'roles_id'=>'required',
            
        ];
    }
    
    protected  function failedValidation(Validator $validator)
    {
        $this->errorResponse($validator->errors());
    }

    public function isSubscriptionsUnique()
    {
        $query=DB::table('model_has_roles');
        $query->where('model_id',$this->user_id);
        $query->whereIn('role_id',is_array($this->roles_id)?$this->roles_id:[$this->roles_id]);
        return $query->doesntExist();
    }
}
