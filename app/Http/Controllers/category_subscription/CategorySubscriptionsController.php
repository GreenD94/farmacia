<?php

namespace App\Http\Controllers\category_subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\category_subscription\StoreRequest;
use App\Http\Requests\category_subscription\UpdateRequest;
use App\Http\Requests\GRequest;
use App\Models\Product;
use App\Models\TagSubscription;
use App\Traits\Responser;
use Carbon\Carbon;

class CategorySubscriptionsController extends Controller
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

    function update(UpdateRequest $request)
    {

            $model    = TagSubscription::whereId( $request->id);
            $data=[];
            if ( $request->has('product_id')) {$data['imageable_id']=$request->product_id;}
            if ( $request->has('category_id')) {$data['tag_id']=$request->category_id;}
            $result=$model->update($data);
            $model    = $model->with('Tag')->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);       
    }

    function destroy(UpdateRequest $request)
    {
            $model =TagSubscription::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
    }


    public function store(StoreRequest $request)
    {             
            $model=Product::find($request->product_id);
            $model->Images()->create(
                [
                    'tag_id'=>$request->category_id
                ]);
            $result=$model->load('Categories');
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->where('imageable_type',Product::class);
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('imageable_id',$request->product_id,$request->product_id_operator);
        $query          ->  SearchBy('tag_id',$request->category_id,$request->category_id_operator);

        
        $query          ->  SearchByRelationship('Tag','name',$request->category_name,$request->category_name_operator);
        $query          ->  SearchByRelationship('Tag','type','product_category');

        return  $query;
    }

    


}
