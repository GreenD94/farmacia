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
            $isloginSuccess=Auth::attempt($request->only(['email','password']));
            if (!$isloginSuccess) {return $this->errorResponse(['password'=>'wrong password'],'failed to login', 401);}
            $user = User::where('email', $request->email)->with(['address.state.country','SocialMediaSubscription.SocialMedia','offices.address.state.country'])->first();
            $token= $user->createToken('auth_token')->plainTextToken;

            $addres= $user->address;
            $addres=(!!$addres)?$addres->makeHidden(['id','addressable_type','addressable_id','state_id','created_at','updated_at'])->attributesToArray():[];
            $state= $user->address->state;
            $state=(!!$state)?$state->makeHidden(['id','country_id','created_at','updated_at'])->attributesToArray():[];       
            $country= $user->address->state->country;
            $country=(!!$country)?$country->makeHidden(['id','code','image','created_at','updated_at'])->attributesToArray():[];
            $socialMediaSubscriptions=$user->SocialMediaSubscription->makeHidden(['id','subscribable_type','subscribable_id','tag_id','created_at','updated_at']);
            $socialMedia=[];
            foreach ($socialMediaSubscriptions as $key => $Subscription) 
            {
                $socialMedia=array_merge($socialMedia,[$Subscription->SocialMedia->name=>$Subscription->name]);
            }
            $offices= $user->offices;
            $offices=(!!$offices)?$offices->makeHidden(['company_id','created_at','updated_at']):[];
            $shops=$offices->map(function ($item, $key) {
                $addres= $item->address;
                $addres=(!!$addres)?$addres->makeHidden(['id','addressable_type','addressable_id','state_id','created_at','updated_at'])->attributesToArray():[];
                $state= $item->address->state;
                $state=(!!$state)?$state->makeHidden(['id','country_id','created_at','updated_at'])->attributesToArray():[];       
                $country= $item->address->state->country;
                $country=(!!$country)?$country->makeHidden(['id','code','image','created_at','updated_at'])->attributesToArray():[];
                $shop=$item->attributesToArray();
                return array_merge($shop,$addres,[
                    'state' => $state['name'],
                    'country' => $country['name'],
                ]);                
            });
            $result=array_merge($user->attributesToArray(),$addres, $socialMedia,[
                'state' => $state['name'],
                'country' => $country['name'],
                'shops'=>$shops,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
            return $this->successResponse($result,'successful login',202);
    }
}
