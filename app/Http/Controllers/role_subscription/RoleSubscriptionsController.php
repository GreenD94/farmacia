<?php

namespace App\Http\Controllers\role_subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\GRequest;
use App\Http\Requests\role_subscription\StoreRequest;
use App\Http\Requests\role_subscription\UpdateRequest;
use App\Models\User;
use App\Traits\Responser;
class RoleSubscriptionsController extends Controller
{
    use Responser;

//     function index(GRequest $request)
//     {
        
    
//     }
  

//     function show(GRequest $request){
      
//     }

//      function update(UpdateRequest $request)
//     {
//     }

    function destroy(UpdateRequest $request)
    {
            $model =User::find( $request->user_id);  
            $result=$model->removeRole($request->role_id);
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);   
    }


    public function store(StoreRequest $request)
    {       
            $model    =   User::find( $request->user_id);         
            $result= $model->assignRole($request->roles_id);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


//     public function FilterQuery($query,$request)
//     {
//         return  $query;
//     }
    


}
