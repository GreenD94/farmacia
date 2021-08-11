<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\StoreRequest;
use App\Http\Requests\user\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{





    function index(request $request)
    {
        if(!$request->ajax()){return response()->json('only ajax is accepted', 403);}    
        $Query         = (new User())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        return response()->json($result, 200);
            
        
    }
  

    function show(request $request){
        if(!$request->ajax()){return response()->json('only ajax is accepted', 403);}
            $Query         = (new User())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return response()->json($result, 200);
        
    }

    function update(UpdateRequest $request)
    {
        if(!$request->ajax()){return response()->json('only ajax is accepted', 403);}
            $model    =   User::whereId( $request->id);
            $data=$request->except(['id','password']);
            if ($request->has('password')){$data['password']=Hash::make($request->password);}
            $result=$model->update( $data);
            $model    = $model->first();
            $response= (!!$result)?response()->json($model, 200):response()->json($model, 401);
            return $response;
        
    }

    function destroy(UpdateRequest $request)
    {
        if(!$request->ajax()){return response()->json('only ajax is accepted', 403);}
            $model =User::find($request->id);
            $result=$model->delete();
            $response= (!!$result)?response()->json($model, 200):response()->json($model, 401);
            return $response;
            
    }


    public function store(StoreRequest $request)
    {
        if(!$request->ajax()){return response()->json('only ajax is accepted', 403);}          
            $data=$request->all();
            $data['password']=  Hash::make($request->password);
            $result=User::create($data);
            $response= (!!$result)?response()->json($result, 201):response()->json($result, 401);
            return $response;
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('first_name',$request->first_name,$request->first_name_operator);  
        $query          ->  SearchBy('email',$request->email,$request->email_operator);  
        $query          ->  SearchBy('password',$request->password,$request->password_operator);  
        $query          ->  SearchBy('phone',$request->phone,$request->phone_operator);

        $query          ->  SearchByRelationship('OfficeSubscriptions','branch_office_id',$request->OfficeSubscriptions_branch_office_id,$request->OfficeSubscriptions_branch_office_id_operator);
        $query          ->  SearchByRelationship('OfficeSubscriptions','user_id',$request->OfficeSubscriptions_user_id,$request->OfficeSubscriptions_user_id_operator);
        $query          ->  SearchByRelationship('OfficeSubscriptions','active',$request->OfficeSubscriptions_active,$request->OfficeSubscriptions_active_operator);          

        $query          ->  SearchByRelationship('offices','company_id',$request->offices_company_id,$request->offices_company_id_operator);  
        $query          ->  SearchByRelationship('offices','name',$request->offices_name,$request->offices_name_operator);
        $query          ->  SearchByRelationship('offices','dni',$request->offices_dni,$request->offices_dni_operator);
        $query          ->  SearchByRelationship('offices','phone',$request->offices_phone,$request->offices_phone_operator);
        $query          ->  SearchByRelationship('offices','email',$request->offices_email,$request->offices_email_operator);        

        
        $query          ->  SearchByRelationship('address','addressable_type',$request->address_addressable_type,$request->address_addressable_type_operator);
        $query          ->  SearchByRelationship('address','addressable_id',$request->address_addressable_id,$request->address_addressable_id_operator);  
        $query          ->  SearchByRelationship('address','adress',$request->address_adress,$request->address_adress_operator);  
        $query          ->  SearchByRelationship('address','city',$request->address_city,$request->address_city_operator);  
        $query          ->  SearchByRelationship('address','latitude',$request->address_latitude,$request->address_latitude_operator);  
        $query          ->  SearchByRelationship('address','longitude',$request->address_longitude,$request->address_longitude_operator);  
        $query          ->  SearchByRelationship('address','background_color',$request->address_background_color,$request->address_background_color_operator);  
        $query          ->  SearchByRelationship('address','main_color',$request->address_main_color,$request->address_main_color_operator);  
        $query          ->  SearchByRelationship('address','secondary_color',$request->address_secondary_color,$request->address_secondary_color_operator);  
        $query          ->  SearchByRelationship('address','text_one_color',$request->address_text_one_color,$request->address_text_one_color_operator);  
        $query          ->  SearchByRelationship('address','text_two_color',$request->address_text_two_color,$request->address_text_two_color_operator);  
        $query          ->  SearchByRelationship('address','logo_white',$request->address_logo_white,$request->address_logo_white_operator);  
        $query          ->  SearchByRelationship('address','active',$request->address_active,$request->address_active_operator);  


        return  $query;
    }


}
