<?php

namespace App\Http\Controllers\color;

use App\Http\Controllers\Controller;
use App\Http\Requests\color\OfficeStoreRequest;
use App\Http\Requests\color\OfficeUpdateRequest;
use App\Http\Requests\GRequest;
use App\Models\BranchOffice;
use App\Models\Image;
use App\Models\TagSubscription;
use App\Traits\Responser;
use Carbon\Carbon;

class OfficeColorController extends Controller
{
    use Responser;
    function index(GRequest $request)
    {
        
        $Query         = (new TagSubscription())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
            
        
    }
  

    function show(GRequest $request){

            $Query         = (new TagSubscription())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(OfficeUpdateRequest $request)
    {

            $model    = TagSubscription::whereId( $request->id);
            if ( $request->has('branch_office_id')) {$data['taggable_id']=$request->branch_office_id;}
            if ( $request->has('name')) {$data['name']=$request->name;}
            if ( $request->has('role_id')) {$data['tag_id']=$request->role_id;}
            $result=$model->update($data);  
            $model    = $model->with('Colors.Tag')->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);       
    }

    function destroy(OfficeUpdateRequest $request)
    {

            $model =TagSubscription::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
            
    }


    public function store(OfficeStoreRequest $request)
    {             
            $model=BranchOffice::find($request->branch_office_id);
            $model->Colors()->create(
                [
                    'name'=>$request->color,
                    'tag_id'=>$request->role_id
                ]); 
            $result=$model->load('Colors.Tag');
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->where('taggable_type','App\Models\BranchOffice');
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('name',$request->first_name,$request->first_name_operator);
        $query          ->  SearchBy('taggable_id',$request->user_id,$request->user_id_operator);
        $query          ->  SearchBy('tag_id',$request->role_id,$request->role_id_operator);
        
        $query          ->  SearchByRelationship('Tag','name',$request->role_name,$request->role_name_operator);
        $query          ->  SearchByRelationship('Tag','type','branch_office_color');

        return  $query;
    }

    


}
