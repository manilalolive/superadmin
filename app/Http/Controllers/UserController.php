<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request)
    {
    	$data=[];
    	$input = [
    		'email' => $request->email,
    		'password' => $request->password
    	];

    	try{
    		$login_user = User::where('email',$request->email)->first();
            if (!$login_user || !Hash::check($request->password, $login_user->password)) {
                throw ValidationException::withMessages([
                    'email' =>'The Provided credentials are wrong!'
                ]);
            }
            $token = $login_user->createToken($login_user->email.'-'.now())->accessToken;
            $data['token'] = $token;
            $data['userId'] = $login_user->id;
            $status = true;
            $message = 'User Login Successfull';
    	} catch (\Exception $e) {
    		$status = false;
            $message = $e->getMessage();
    	}

    	return response()->json([
            'status'=> $status,
            'data'=> $data,
            'message'=> $message
        ]);
    }
}
