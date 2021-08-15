<?php

namespace App\Http\Controllers\branch_office;

use App\Http\Controllers\Controller;
use App\Http\Requests\branch_office\StoreRequest;
use App\Http\Requests\branch_office\UpdateRequest;
use App\Http\Requests\GRequest;
use App\Models\BranchOffice;
use App\Traits\Responser;

class BranchOfficesController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new BranchOffice())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
    }
  

    function show(GRequest $request){

            $Query         = (new BranchOffice())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(UpdateRequest $request)
    {

            $model    =   BranchOffice::whereId( $request->id);
            $data=$request->only(['company_id','name','dni','phone','email','active']);
            $result=$model->update( $data);
            $model    = $model->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);
        
    }

    function destroy(UpdateRequest $request)
    {

            $model =BranchOffice::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
            
    }


    public function store(StoreRequest $request)
    {
            $data=$request->only(['company_id','name','dni','phone','email','active']);
            $result=BranchOffice::create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;

        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('company_id',$request->company_id,$request->company_id_operator);
        $query          ->  SearchBy('name',$request->name,$request->name_operator);
        $query          ->  SearchBy('dni',$request->dni,$request->dni_operator);
        $query          ->  SearchBy('phone',$request->phone,$request->phone_operator);
        $query          ->  SearchBy('email',$request->email,$request->email_operator);
        $query          ->  SearchBy('active',$request->active,$request->active_operator);


        
        $query          ->  SearchByRelationship('OfficeSubscriptions','user_id',$request->OfficeSubscriptions_user_id,$request->OfficeSubscriptions_user_id_operator);
        $query          ->  SearchByRelationship('OfficeSubscriptions','active',$request->OfficeSubscriptions_active,$request->OfficeSubscriptions_active_operator);          

        $query          ->  SearchByRelationship('Company','id',$request->Company_id,$request->Company_id_operator);  
        $query          ->  SearchByRelationship('Company','name',$request->Company_name,$request->Company_name_operator);  

        $query          ->  SearchByRelationship('Currency','id',$request->Currency_id,$request->Currency_id_operator);
        $query          ->  SearchByRelationship('Currency','value',$request->Currency_value,$request->Currency_value_operator); 
        $query          ->  SearchByRelationship('Currency','tag_id',$request->Currency_tag_id,$request->Currency_tag_id_operator);  

        $query          ->  SearchByRelationship(['Currency','Tag'],'tags.name',$request->Currency_tag_name,$request->Currency_tag_name_operator);

        $query          ->  SearchByRelationship('Products','id',$request->Products_id,$request->Products_id_operator);
        $query          ->  SearchByRelationship('Products','branch_office_id',$request->Products_branch_office_id,$request->Products_branch_office_id_operator);
        $query          ->  SearchByRelationship('Products','product_detail_id',$request->Products_product_detail_id,$request->Products_product_detail_id_operator);
        $query          ->  SearchByRelationship('Products','price',$request->Products_price,$request->Products_price_operator);
        $query          ->  SearchByRelationship('Products','show_price',$request->Products_show_price,$request->Products_show_price_operator);
        $query          ->  SearchByRelationship('Products','available',$request->Products_available,$request->Products_available_operator);


        $query          ->  SearchByRelationship('ProductDetails','name',$request->ProductDetails_name,$request->ProductDetails_name_operator);
        $query          ->  SearchByRelationship('ProductDetails','description',$request->ProductDetails_description,$request->ProductDetails_description_operator);
        
        $query          ->  SearchByRelationship(['ProductDetails'.'Categories'],'tags.id',$request->ProductCategories_id,$request->ProductCategories_id_operator);
        $query          ->  SearchByRelationship(['ProductDetails'.'Categories'],'tags.name',$request->ProductCategories_name,$request->ProductCategories_name_operator);
        

        $query          ->  SearchByRelationship('address','addressable_id',$request->address_branch_office,$request->address_branch_office_operator);  
        $query          ->  SearchByRelationship('address','adress',$request->address_adress,$request->address_adress_operator);  
        $query          ->  SearchByRelationship('address','city',$request->address_city,$request->address_city_operator);  
        $query          ->  SearchByRelationship('address','latitude',$request->address_latitude,$request->address_latitude_operator);  
        $query          ->  SearchByRelationship('address','longitude',$request->address_longitude,$request->address_longitude_operator);  
        $query          ->  SearchByRelationship('address','active',$request->address_active,$request->address_active_operator);  

        $query          ->  SearchByRelationship(['address','state'],'states.id',$request->state_id,$request->state_id_operator);  
        $query          ->  SearchByRelationship(['address','state'],'states.country_id',$request->state_country_id,$request->state_country_id_operator);  
        $query          ->  SearchByRelationship(['address','state'],'states.name',$request->state_name,$request->state_name_operator); 

        $query          ->  SearchByRelationship(['address','state','country'],'countries.id',$request->country_id,$request->country_id_operator);        
        $query          ->  SearchByRelationship(['address','state','country'],'countries.code',$request->country_code,$request->country_code_operator);        
        $query          ->  SearchByRelationship(['address','state','country'],'countries.name',$request->country_name,$request->country_name_operator);  
        $query          ->  SearchByRelationship(['address','state','country'],'countries.image',$request->country_image,$request->country_image_operator); 


        return  $query;
    }
    


}
