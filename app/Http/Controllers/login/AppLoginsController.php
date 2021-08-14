<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use App\Http\Requests\login\StoreRequest;
use App\Models\User;
use App\Traits\Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppLoginsController  extends Controller
{
    use Responser;
    function store(StoreRequest $request)
    {
            // $isloginSuccess=Auth::attempt($request->only(['email','password']));
            // if (!$isloginSuccess) {return $this->errorResponse(['password'=>'wrong password'],'failed to login', 401);}
            $user = User::where('email', $request->email)->with(
                [
                    'Address.State.Country',
                    'SocialMediaSubscription.SocialMedia',
                    'Offices.Address.State.Country',
                    'Offices.Images.Detail',
                    'Offices.Images.Tag',
                    'Offices.Colors.Tag',
                    'Images.Detail',
                    'Images.Tag',
                    'roles'
                ])->first();
            $token= $user->createToken('auth_token')->plainTextToken;
            $roles=(!!$user->roles)?$user->roles->makeHidden(['id','guard_name','created_at','updated_at'])->first()->name:null;
            $addres=(!!$user->address)?$user->address->makeHidden(['id','addressable_type','addressable_id','state_id','latitude','longitude','created_at','updated_at'])->attributesToArray():[];
            $state=(!!$user->address->state)?$user->address->state->makeHidden(['id','country_id','created_at','updated_at'])->attributesToArray():[];       
            $country=(!!$user->address->state->country)?$user->address->state->country->makeHidden(['id','code','image','created_at','updated_at'])->attributesToArray():[];
            $socialMediaSubscriptions=($user->SocialMediaSubscription)?$user->SocialMediaSubscription->makeHidden(['id','taggable_type','taggable_id','tag_id','created_at','updated_at']):[];
            $socialMedia=[];
            foreach ($socialMediaSubscriptions as $key => $Subscription) 
            {
                $socialMedia=array_merge($socialMedia,[$Subscription->SocialMedia->name=>$Subscription->name]);
            }

           $offices=(!!$user->Offices)?$user->Offices->makeHidden(['company_id','created_at','updated_at']):[];
            $shops=$offices->map(function ($item, $key) {
                $addres=(!!$item->address)?$item->address->makeHidden(['id','addressable_type','addressable_id','state_id','created_at','updated_at'])->attributesToArray():[];
                $state=(!!$item->address->state)?$item->address->state->makeHidden(['id','country_id','created_at','updated_at'])->attributesToArray():[];       
                $country=(!!$item->address->state->country)?$item->address->state->country->makeHidden(['id','code','image','created_at','updated_at'])->attributesToArray():[];
                $shop=$item->attributesToArray();
                $colors=(!!$item->Colors)?$item->Colors->map(function ($color, $key){return array( $color->tag->name  =>$color->name );})->collapse()->toArray():[]; 
                $images=(!!$item->Images)?$item->Images->map(function ($image, $key){return array( $image->tag->name  =>$image->Detail->path );})->collapse()->toArray():[]; 

                return array_merge($shop, $colors,$images,$addres,[
                    'state' => $state['name'],
                    'country' => $country['name'],
                ]);                
            });
            
            $result=array_merge($user->attributesToArray(),['role'=>$roles],$addres,$socialMedia, [
                'state' => $state['name'],
                'country' => $country['name'],
                'shops'=>$shops,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
            
            return $this->successResponse($result,'successful login',202);
    }
}
