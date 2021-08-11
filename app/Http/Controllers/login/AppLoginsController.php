<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use App\Http\Requests\login\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppLoginsController  extends Controller
{


    function store(StoreRequest $request)
    {
        //if(!$request->ajax()){return response()->json('only ajax is accepted',403);}
            $isloginSuccess=Auth::attempt($request->only(['email','password']));
            if (!$isloginSuccess) {return response()->json(['password'=>'wrong password'], 401);}
            $user = User::where('email', $request->email)->with(['address.state.country','SocialMediaSubscription.SocialMedia'])->first();
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
            $result=array_merge($user->attributesToArray(),$addres, $socialMedia,[
                'state' => $state['name'],
                'country' => $country['name'],
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
            return response()->json($result, 202);
    }
}
