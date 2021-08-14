<?php

namespace App\Http\Controllers\color_tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\color_role\OfficeStoreRequest;
use App\Http\Requests\color_role\OfficeUpdateRequest;
use App\Http\Requests\GRequest;
use App\Models\Tag;
use App\Traits\Responser;


use Illuminate\Support\Facades\Hash;


class OfficeColorRolesController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new Tag())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
            
        
    }
  

    function show(GRequest $request){

            $Query         = (new Tag())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(OfficeUpdateRequest $request)
    {

            $model    =   Tag::whereId( $request->id);
            $data=$request->only(['name']);
            $result=$model->update( $data);
            $model    = $model->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);       
    }

    function destroy(OfficeUpdateRequest $request)
    {
            $model =Tag::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
            
    }


    public function store(OfficeStoreRequest $request)
    {      
            $data=$request->only('name');
            $data['type']='branch_office_color';
            $result=Tag::create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->where('type','branch_office_color');
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('name',$request->first_name,$request->first_name_operator);  

        return  $query;
    }


}
