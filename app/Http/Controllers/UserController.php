<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $status = false;
        $user_data = null;
        try{
            $data=$request->validated();
            $data['password'] = Hash::make($request->password);
            $data['user_type'] = "organization_user";
            $user_data = User::create($data);
            if($user_data){
                $status = true;
                $message = 'User details added successfully';
            } else {
                $message = 'User details not added';
            }
        } catch (\Exception $e) {
            $message = 'something went wrong';
            #$message = $e->getMessage();
        }
        return response()->json([
            'status' => $status,
            'data' => $user_data,
            'message' => $message,
        ]);
    }

    public function login(Request $request)
    {
    	$data=[];
    	$input = [
    		'email' => $request->input("email"),
    		'password' => $request->input("password")
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
