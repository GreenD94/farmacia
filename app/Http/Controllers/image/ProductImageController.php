<?php

namespace App\Http\Controllers\image;

use App\Http\Controllers\Controller;
use App\Http\Requests\GRequest;
use App\Http\Requests\image\ProductStoreRequest;
use App\Http\Requests\image\ProductUpdateRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use App\Traits\Responser;
use Carbon\Carbon;

class ProductImageController extends Controller
{
    use Responser;
    function index(GRequest $request)
    {
        $Query         = (new Image())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);        
    }
  

    function show(GRequest $request){

            $Query         = (new Image())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
        
    }

    function update(ProductUpdateRequest $request)
    {

            $model    = Image::whereId( $request->id);
            $data=[];
            if ( $request->has('product_id')) {$data['imageable_id']=$request->product_id;}
            if ( $request->has('path')) {$data['path']=$request->path;}
            if ( $request->has('name')) {$data['name']=$request->name;}
            if ( $request->has('role_id')) {$data['tag_id']=$request->role_id;}
            $result=$model->update($data);
            if ( $request->has('image'))
            {
                $image=  $request->file('image');
                //modificar calidad de imagen aqui
                //usar api externa aqui
            }    
            $model    = $model->with('Tag')->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);       
    }

    function destroy(ProductUpdateRequest $request)
    {
            $model =Image::find($request->id);
            //poner api externa aqui para liminar la imagem
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);
    }


    public function store(ProductStoreRequest $request)
    {             
            $model=Product::find($request->product_id);
            $model->Images()->create(
                [
                    'path'=>$request->path,
                    'name'=>$model->id.'_product_image_'.Carbon::now()->toDateTimeString().rand(),
                    'tag_id'=>$request->role_id
                ]);
            if ( $request->has('image'))
            {
                $image=  $request->file('image');
                //modificar calidad de imagen aqui
                //usar api externa aqui
            }           
            $result=$model->load('Images.Tag');
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;
        $query          ->where('imageable_type',Product::class);
        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('name',$request->first_name,$request->first_name_operator);
        $query          ->  SearchBy('imageable_id',$request->product_id,$request->product_id_operator);
        $query          ->  SearchBy('tag_id',$request->role_id,$request->role_id_operator);
        $query          ->  SearchBy('path',$request->path,$request->path_operator);
        
        $query          ->  SearchByRelationship('Tag','name',$request->role_name,$request->role_name_operator);
        $query          ->  SearchByRelationship('Tag','type','product_image');

        return  $query;
    }

    


}
