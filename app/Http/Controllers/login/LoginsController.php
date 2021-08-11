<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use App\Http\Requests\login\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginsController extends Controller
{


    function store(StoreRequest $request)
    {
        if(!$request->ajax()){return response()->json('only ajax is accepted', 403);}
            $isloginSuccess=Auth::attempt($request->only(['email','password']));
            if (!$isloginSuccess) {return response()->json(['password'=>'wrong password'], 401);}
            $user = User::where('email', $request->email)->first();
            $token= $user->createToken('auth_token')->plainTextToken;            
            $result=array_merge($user->toArray(),[
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
            return response()->json($result, 202);
    }
}
