<?php

namespace App\Http\Controllers\role;

use App\Http\Controllers\Controller;
use App\Http\Requests\GRequest;
use App\Http\Requests\role\StoreRequest;
use App\Http\Requests\role\UpdateRequest;
use App\Traits\Responser;
use Spatie\Permission\Models\Role;
class RolesController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new Role())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();        
        return $this->successResponse($result);     
    }
  

    function show(GRequest $request){
            $Query         = (new Role())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);       
    }

    function update(UpdateRequest $request)
    {
            $model    =   Role::whereId( $request->id);
            $data=$request->only(['name']);
            $result=$model->update( $data);
            $model    = $model->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);
    }

    function destroy(UpdateRequest $request)
    {
            $model =Role::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);   
    }


    public function store(StoreRequest $request)
    {          
            $data=$request->all();
            $result=Role::create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('name',$request->name,$request->name_operator);
        return  $query;
    }
    


}
