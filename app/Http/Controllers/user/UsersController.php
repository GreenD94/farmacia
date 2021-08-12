<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\GRequest;
use App\Http\Requests\user\StoreRequest;
use App\Http\Requests\user\UpdateRequest;
use App\Models\User;
use App\Traits\Responser;


use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new User())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
            
        
    }
  

    function show(GRequest $request){

            $Query         = (new User())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(UpdateRequest $request)
    {

            $model    =   User::whereId( $request->id);
            $data=$request->except(['id','password']);
            if ($request->has('password')){$data['password']=Hash::make($request->password);}
            $result=$model->update( $data);
            $model    = $model->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);
        
    }

    function destroy(UpdateRequest $request)
    {

            $model =User::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
            
    }


    public function store(StoreRequest $request)
    {
                  
            $data=$request->all();
            $data['password']=  Hash::make($request->password);
            $result=User::create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('first_name',$request->first_name,$request->first_name_operator);  
        $query          ->  SearchBy('email',$request->email,$request->email_operator);  
        $query          ->  SearchBy('password',$request->password,$request->password_operator);  
        $query          ->  SearchBy('phone',$request->phone,$request->phone_operator);

        $query          ->  SearchByRelationship('OfficeSubscriptions','id',$request->OfficeSubscriptions_id,$request->OfficeSubscriptions_id_operator);
        $query          ->  SearchByRelationship('OfficeSubscriptions','branch_office_id',$request->OfficeSubscriptions_branch_office_id,$request->OfficeSubscriptions_branch_office_id_operator);
        $query          ->  SearchByRelationship('OfficeSubscriptions','user_id',$request->OfficeSubscriptions_user_id,$request->OfficeSubscriptions_user_id_operator);
        $query          ->  SearchByRelationship('OfficeSubscriptions','active',$request->OfficeSubscriptions_active,$request->OfficeSubscriptions_active_operator);          

        $query          ->  SearchByRelationship('offices','id',$request->offices_id,$request->offices_id_operator); 
        $query          ->  SearchByRelationship('offices','company_id',$request->offices_company_id,$request->offices_company_id_operator);  
        $query          ->  SearchByRelationship('offices','name',$request->offices_name,$request->offices_name_operator);
        $query          ->  SearchByRelationship('offices','dni',$request->offices_dni,$request->offices_dni_operator);
        $query          ->  SearchByRelationship('offices','phone',$request->offices_phone,$request->offices_phone_operator);
        $query          ->  SearchByRelationship('offices','email',$request->offices_email,$request->offices_email_operator);
        $query          ->  SearchByRelationship('offices','background_color',$request->offices_background_color,$request->offices_background_color_operator);  
        $query          ->  SearchByRelationship('offices','main_color',$request->offices_main_color,$request->offices_main_color_operator);  
        $query          ->  SearchByRelationship('offices','secondary_color',$request->offices_secondary_color,$request->offices_secondary_color_operator);  
        $query          ->  SearchByRelationship('offices','text_one_color',$request->offices_text_one_color,$request->offices_text_one_color_operator);  
        $query          ->  SearchByRelationship('offices','text_two_color',$request->offices_text_two_color,$request->offices_text_two_color_operator);  
        $query          ->  SearchByRelationship('offices','logo_white',$request->offices_logo_white,$request->offices_logo_white_operator);  
        $query          ->  SearchByRelationship('offices','active',$request->offices_active,$request->offices_active_operator);          

        $query          ->  SearchByRelationship('address','id',$request->address_id,$request->address_id_operator);  
        $query          ->  SearchByRelationship('address','addressable_type',$request->address_addressable_type,$request->address_addressable_type_operator);
        $query          ->  SearchByRelationship('address','addressable_id',$request->address_addressable_id,$request->address_addressable_id_operator);  
        $query          ->  SearchByRelationship('address','adress',$request->address_adress,$request->address_adress_operator);  
        $query          ->  SearchByRelationship('address','city',$request->address_city,$request->address_city_operator);  
        $query          ->  SearchByRelationship('address','latitude',$request->address_latitude,$request->address_latitude_operator);  
        $query          ->  SearchByRelationship('address','longitude',$request->address_longitude,$request->address_longitude_operator);  
        $query          ->  SearchByRelationship('address','active',$request->address_active,$request->address_active_operator);  

        $query          ->  SearchByRelationship(['address','state'],'id',$request->state_id,$request->state_id_operator);  
        $query          ->  SearchByRelationship(['address','state'],'country_id',$request->state_country_id,$request->state_country_id_operator);  
        $query          ->  SearchByRelationship(['address','state'],'name',$request->state_name,$request->state_name_operator); 

        $query          ->  SearchByRelationship(['address','state','country'],'id',$request->country_id,$request->country_id_operator);        
        $query          ->  SearchByRelationship(['address','state','country'],'code',$request->country_code,$request->country_code_operator);        
        $query          ->  SearchByRelationship(['address','state','country'],'name',$request->country_name,$request->country_name_operator);  
        $query          ->  SearchByRelationship(['address','state','country'],'image',$request->country_image,$request->country_image_operator);   


        return  $query;
    }


}
