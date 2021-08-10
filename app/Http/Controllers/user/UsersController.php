<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{





    function index(request $request)
    {
        
        if($request->ajax())
        {
            if($request->ajax())
            {
                $Query         = (new User())->newQuery();
                $this->FilterQuery($Query,$request);
        
                $paginate=$request->paginate??60;
                if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
                $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
                return response()->json($result, 200);
            }
        }
    }
  

    function show(request $request){
        if($request->ajax())
        {
            $Query         = (new User())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first();    
            return   $result;
        }
    }

    function update(request $request)
    {
        if($request->ajax())
        {
            $model    =   User::whereId( $request->id);
            $result=$model->update( $request->except('id'));
            $response= (!!$result)?response()->json($model, 201):response()->json($model, 401);
            return $response;
        }
    }

    function destroy(request $request)
    {
        if($request->ajax())
        {
            $model =User::find($request->id);
            $result=$model->delete();
            $response= (!!$result)?response()->json($model, 201):response()->json($model, 401);
            return $response;
        }    
    }


    public function store(request $request)
    {
        if(true)
        {         
            $data=$request->all();
            $data['password']=  Hash::make($request->password);
            $result=User::create($data);
            $response= (!!$result)?response()->json($result, 201):response()->json($result, 401);
            return $response;
        }
    }


    public function FilterQuery($query,$request)
    {
        $query          ->with($request->with);
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('first_name',$request->first_name,$request->first_name_operator);  
        $query          ->  SearchBy('email',$request->email,$request->email_operator);  
        $query          ->  SearchBy('password',$request->password,$request->password_operator);  
        $query          ->  SearchBy('phone',$request->phone,$request->phone_operator);

        $query          ->  scopeSearchByRelationship('OfficeSubscriptions','branch_office_id',$request->OfficeSubscriptions_branch_office_id,$request->OfficeSubscriptions_branch_office_id_operator);
        $query          ->  scopeSearchByRelationship('OfficeSubscriptions','user_id',$request->OfficeSubscriptions_user_id,$request->OfficeSubscriptions_user_id_operator);
        $query          ->  scopeSearchByRelationship('OfficeSubscriptions','active',$request->OfficeSubscriptions_active,$request->OfficeSubscriptions_active_operator);          

        $query          ->  scopeSearchByRelationship('offices','company_id',$request->offices_company_id,$request->offices_company_id_operator);  
        $query          ->  scopeSearchByRelationship('offices','name',$request->offices_name,$request->offices_name_operator);
        $query          ->  scopeSearchByRelationship('offices','dni',$request->offices_dni,$request->offices_dni_operator);
        $query          ->  scopeSearchByRelationship('offices','phone',$request->offices_phone,$request->offices_phone_operator);
        $query          ->  scopeSearchByRelationship('offices','email',$request->offices_email,$request->offices_email_operator);        

        
        $query          ->  scopeSearchByRelationship('address','addressable_type',$request->address_addressable_type,$request->address_addressable_type_operator);
        $query          ->  scopeSearchByRelationship('address','addressable_id',$request->address_addressable_id,$request->address_addressable_id_operator);  
        $query          ->  scopeSearchByRelationship('address','adress',$request->address_adress,$request->address_adress_operator);  
        $query          ->  scopeSearchByRelationship('address','city',$request->address_city,$request->address_city_operator);  
        $query          ->  scopeSearchByRelationship('address','latitude',$request->address_latitude,$request->address_latitude_operator);  
        $query          ->  scopeSearchByRelationship('address','longitude',$request->address_longitude,$request->address_longitude_operator);  
        $query          ->  scopeSearchByRelationship('address','background_color',$request->address_background_color,$request->address_background_color_operator);  
        $query          ->  scopeSearchByRelationship('address','main_color',$request->address_main_color,$request->address_main_color_operator);  
        $query          ->  scopeSearchByRelationship('address','secondary_color',$request->address_secondary_color,$request->address_secondary_color_operator);  
        $query          ->  scopeSearchByRelationship('address','text_one_color',$request->address_text_one_color,$request->address_text_one_color_operator);  
        $query          ->  scopeSearchByRelationship('address','text_two_color',$request->address_text_two_color,$request->address_text_two_color_operator);  
        $query          ->  scopeSearchByRelationship('address','logo_white',$request->address_logo_white,$request->address_logo_white_operator);  
        $query          ->  scopeSearchByRelationship('address','active',$request->address_active,$request->address_active_operator);  


        return  $query;
    }


}
