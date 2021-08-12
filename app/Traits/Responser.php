<?php
namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait Responser{

    protected function successResponse($data=null ,$message = 'OK', $code = 200)
	{
		return response()->json([
			'message'   => $message,
			'data'      => $data
		], $code);
	}

	protected function errorResponse($data=null,$message = 'Bad Request', $code = 400, )
	{
		throw new HttpResponseException( response()->json([
			'message'   => $message,
			'data'      => $data
		], $code));
	}
}
