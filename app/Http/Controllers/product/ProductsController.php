<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;

use App\Http\Requests\GRequest;
use App\Http\Requests\product\StoreRequest;
use App\Http\Requests\product\UpdateRequest;
use App\Models\Companies;
use App\Models\Product;
use App\Traits\Responser;

class ProductsController extends Controller
{
    use Responser;

    function index(GRequest $request)
    {
        
        $Query         = (new Product())->newQuery();
        $this->FilterQuery($Query,$request);
        $paginate=$request->paginate??60;
        if ($request->orderBy){ $Query->orderby($request->orderByColumn,$request->orderByType);}
        $result=$request->isPaginate?$Query->paginate($paginate):$Query->get();
        
        return $this->successResponse($result);
    }
  

    function show(GRequest $request){

            $Query         = (new Product())->newQuery();
            $this->FilterQuery($Query,$request);
            $result=$Query->first(); 
            return $this->successResponse($result);
    }

    function update(UpdateRequest $request)
    {
            $model    =   Product::whereId( $request->id);
            $data=$request->only(['branch_office_id','product_detail_id','price','show_price','available']);
            $result=$model->update( $data);
            $model    = $model->first();
            return (!!$result)?$this->successResponse($model,'successful update'):$this->errorResponse($model,'failed to update', 401);        
    }

    function destroy(UpdateRequest $request)
    {
            $model =Product::find($request->id);
            $result=$model->delete();
            return (!!$result)?$this->successResponse($model,'successful destroy'):$this->errorResponse($model,'failed to destroy', 401);            
    }


    public function store(StoreRequest $request)
    {                  
            $data=$request->only(['branch_office_id','product_detail_id','price','show_price','available']);
            $result=Product::create($data);
            return (!!$result)?$this->successResponse($result,'successful store',201):$this->errorResponse($result,'failed to store', 401);
    }


    public function FilterQuery($query,$request)
    {
        $request->has('with')?$query->with($request->with):null;

        $query          ->  SearchBy('id',$request->id,$request->id_operator);
        $query          ->  SearchBy('branch_office_id',$request->branch_office_id,$request->branch_office_id_operator);
        $query          ->  SearchBy('product_detail_id',$request->product_detail_id,$request->product_detail_id_operator);
        $query          ->  SearchBy('price',$request->price,$request->price_operator);
        $query          ->  SearchBy('show_price',$request->show_price,$request->show_price_operator);
        $query          ->  SearchBy('available',$request->available,$request->available_operator);

        $query          ->  SearchByRelationship('BranchOffice','company_id',$request->BranchOffice_company_id,$request->BranchOffice_company_id_operator);
        $query          ->  SearchByRelationship('BranchOffice','name',$request->BranchOffice_name,$request->BranchOffice_name_operator); 
        $query          ->  SearchByRelationship('BranchOffice','dni',$request->BranchOffice_dni,$request->BranchOffice_dni_operator); 
        $query          ->  SearchByRelationship('BranchOffice','phone',$request->BranchOffice_phone,$request->BranchOffice_phone_operator); 
        $query          ->  SearchByRelationship('BranchOffice','email',$request->BranchOffice_email,$request->BranchOffice_email_operator); 
        $query          ->  SearchByRelationship('BranchOffice','active',$request->BranchOffice_active,$request->BranchOffice_active_operator);  

        $query          ->  SearchByRelationship('ProductDetail','name',$request->ProductDetail_name,$request->ProductDetail_name_operator); 
        $query          ->  SearchByRelationship('ProductDetail','description',$request->ProductDetail_description,$request->ProductDetail_description_operator); 

        $query          ->  SearchByRelationship('Categories','name',$request->Categories_name,$request->Categories_name_operator); 
        return  $query;
    }
    


}
