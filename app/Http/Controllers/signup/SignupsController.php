<?php

namespace App\Http\Controllers\signup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SignupsController extends Controller
{


    function index(request $request)
    {
        $routes =   [   
            'api_users_store'         =>  route('api.users.store'),
            'chat'         =>  route('chat'),
        ];
        $routes=json_encode($routes);           
        return view('signup.signup')->with('routes',$routes);;
    }

}
