<?php

namespace App\Http\Controllers\office_subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\office_subscription\StoreRequest;
use App\Http\Requests\office_subscription\UpdateRequest;
use App\Models\OfficeSubscription;
use App\Models\User;
use App\Traits\Responser;
class OfficeSubscriptionsController extends Controller
{
    use Responser;

//     function index(GRequest $request)
//     {
        
    
//     }
  

//     function show(GRequest $request){
      
//     }

    function update(UpdateRequest $request)
    {
        $relationships=['user', 'BranchOffice'];
        $model =OfficeSubscription::whereId( $request->id);        
        $data=$request->except(['id','status_id']);
        if ($request->has('status_id'))
        {
            $subscription=$model->first();
            $status=$subscription->Statuses()->first();
            $subscription->Statuses()->sync([$request->status_id]);
            $subscription->StatusLogs()->create(['tag_id' => $status->id]);
            array_push($relationships,'Statuses','StatusLogs.Tag');
        }
        $result=$model->update($data);
        $model    = $model->with($relationships)->first();
        return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);        
    }

    function destroy(UpdateRequest $request)
    {
            $model =OfficeSubscription::find( $request->id);  
            $model->Statuses()->detach();
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);   
    }


    public function store(StoreRequest $request)
    {       
            $model    =   User::find( $request->user_id);         
            $model->Offices()->attach($request->branch_office_id,$request->only('active'));
            $result=OfficeSubscription::where('user_id',$request->user_id)->where('branch_office_id',$request->branch_office_id)->latest('id')->first();
            $result->Statuses()->attach($request->status_id);
            $result->load('user', 'BranchOffice','Statuses');
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


//     public function FilterQuery($query,$request)
//     {
//         return  $query;
//     }
    


}
