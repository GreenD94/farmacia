<?php

namespace App\Http\Controllers\currency;

use App\Http\Controllers\Controller;
use App\Http\Requests\currency\StoreRequest;
use App\Http\Requests\currency\UpdateRequest;
use App\Http\Requests\GRequest;
use App\Models\Currency;
use App\Traits\Responser;


use Illuminate\Support\Facades\Hash;


class CurrenciesController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new Currency())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
            
        
    }
  

    function show(GRequest $request){

            $Query         = (new Currency())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(UpdateRequest $request)
    {

            $model    =   Currency::whereId( $request->id);
            $data=$request->only(['tag_id','branch_office_id','value']);
            $result=$model->update( $data);
            $model    = $model->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);       
    }

    function destroy(UpdateRequest $request)
    {

            $model =Currency::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
            
    }


    public function store(StoreRequest $request)
    {
                  
            $data=$request->only(['tag_id','branch_office_id','value']);
            $result=Currency::create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;

        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('tag_id',$request->tag_id,$request->tag_id_operator);  
        $query          ->  SearchBy('branch_office_id',$request->branch_office_id,$request->branch_office_id_operator);  
        $query          ->  SearchBy('value',$request->value,$request->value_operator);  

        $query          ->  SearchByRelationship('Tag','name',$request->Tag_name,$request->Tag_name_operator);
        $query          ->  SearchByRelationship('Tag','type',$request->Tag_type,$request->Tag_type_operator);


        return  $query;
    }


}
