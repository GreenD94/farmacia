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


    function index(request $request)
    {
        
        $routes =   [   
            'api_login'         =>  route('api.login.store'),
            'chat'         =>  route('chat'),
        ];
        $routes=json_encode($routes);           
        return view('login.login')->with('routes',$routes);;
    }

    function store(StoreRequest $request)
    {
            $isloginSuccess=Auth::attempt($request->only(['email','password']));
            if (!$isloginSuccess) {return response()->json(['password'=>'wrong password'], 401);}
            $user = User::where('email', $request->email)->first();
            $token= $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
    }
}
