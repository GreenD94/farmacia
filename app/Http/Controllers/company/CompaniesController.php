<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Http\Requests\companies\StoreRequest;
use App\Http\Requests\companies\UpdateRequest;
use App\Http\Requests\GRequest;
use App\Models\Companies;
use App\Traits\Responser;

class CompaniesController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new Companies())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
            
        
    }
  

    function show(GRequest $request){

            $Query         = (new Companies())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(UpdateRequest $request)
    {

            $model    =   Companies::whereId( $request->id);
            $data=$request->only('name');;
            $result=$model->update( $data);
            $model    = $model->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);
        
    }

    function destroy(UpdateRequest $request)
    {

            $model =Companies::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
            
    }


    public function store(StoreRequest $request)
    {
                  
            $data=$request->only('name');
            $result=Companies::create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;

        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('name',$request->name,$request->name_operator);



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


        return  $query;
    }
    


}
