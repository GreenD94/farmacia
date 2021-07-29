<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
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

    function store(request $request)
    {
            $login=Auth::attempt($request->only(['email','password']));
            return $login;
    }
}
