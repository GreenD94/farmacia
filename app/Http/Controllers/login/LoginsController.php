<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use App\Http\Requests\login\StoreRequest;
use App\Models\User;
use App\Traits\Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginsController extends Controller
{
    use Responser;

    function store(StoreRequest $request)
    {
        
            $isloginSuccess=Auth::attempt($request->only(['email','password']));
            if (!$isloginSuccess) {return $this->errorResponse(['password'=>'wrong password'],'failed to login', 401);}
            $user = User::where('email', $request->email)->first();
            $token= $user->createToken('auth_token')->plainTextToken;            
            $result=array_merge($user->toArray(),[
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
            return $this->successResponse($result,'successful login',202);
    }
}
