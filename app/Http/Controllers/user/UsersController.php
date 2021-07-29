<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{





    function index(request $request)
    {
        
        if($request->ajax())
        {
            return User::all();
        }
    }
  

    function update(request $request)
    {
        // if($request->ajax())
        // {
        //     $user   =   $this->UserUpdate($request->input('id'),$request->except('id'));
        //     if($user){
        //         return $this->successResponse($request->input('type').' actualizado','0001',201,['status'=>$request->input('status')]);
        //     }
        //     else{
        //         return $this->errorResponse('Fallo actualizando'.$request->input('type'),'0002',401);
        //     }
        // }
    }

    function destroy(request $request)
    {
        // if($request->ajax())
        // {
        //     $user  =   $this->UserDestroy($request->input('id'));
        //     if($user){
        //         return $this->successResponse('Usuario Borrado Correctamente',201);
        //     }
        //     else{
        //         return $this->errorResponse('Fallo Borrando Usuario',401);
        //     }
        // }    
    }


    public function store(request $request)
    {
        if($request->ajax())
        {         
            $data=$request->all();
            $data['password']=  Hash::make($request->password);
            return User::create($data);
        }
    }

}
