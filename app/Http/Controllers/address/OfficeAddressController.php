<?php

namespace App\Http\Controllers\address;

use App\Http\Controllers\Controller;
use App\Http\Requests\address\OfficeStoreRequest;
use App\Http\Requests\address\OfficeUpdateRequest;
use App\Http\Requests\GRequest;
use App\Models\Address;
use App\Models\BranchOffice;
use App\Traits\Responser;


use Illuminate\Support\Facades\Hash;


class OfficeAddressController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new Address())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
            
        
    }
  

    function show(GRequest $request){

            $Query         = (new Address())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(OfficeUpdateRequest $request)
    {

            $model =Address::where('id',$request->id);
            $data=$request->only(['state_id','adress','city','latitude','longitude','active']);
            if ($request->has('branch_office_id')){$data['addressable_id']=$request->branch_office_id;}
            $result=$model->update( $data);
            $model    = $model->with('State.Country')->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);       
    }

    function destroy(OfficeUpdateRequest $request)
    {

            $model =Address::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
            
    }


    public function store(OfficeStoreRequest $request)
    {
            $model=BranchOffice::find($request->branch_office_id);  
            $data=$request->only(['state_id','adress','city','latitude','longitude','active']);
            $result=$model->Address()->create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->where('addressable_type','App\Models\BranchOffice');
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('addressable_id',$request->branch_office_id,$request->branch_office_id_operator);
        $query          ->  SearchBy('state_id',$request->state_id,$request->state_id_operator);  
        $query          ->  SearchBy('adress',$request->adress,$request->adress_operator);  
        $query          ->  SearchBy('city',$request->city,$request->city_operator);
        $query          ->  SearchBy('latitude',$request->latitude,$request->latitude_operator);
        $query          ->  SearchBy('longitude',$request->longitude,$request->longitude_operator);
        $query          ->  SearchBy('active',$request->active,$request->active_operator);  

        $query          ->  SearchByRelationship('State','name',$request->State_name,$request->State_name_operator);
        $query          ->  SearchByRelationship('State','type',$request->State_type,$request->State_type_operator);

        $query          ->  SearchByRelationship(['State','Country'],'id',$request->Country_id,$request->Country_id_operator);
        $query          ->  SearchByRelationship(['State','Country'],'name',$request->Country_name,$request->Country_name_operator);
        $query          ->  SearchByRelationship(['State','Country'],'code',$request->Country_code,$request->Country_code_operator);


        return  $query;
    }


}
