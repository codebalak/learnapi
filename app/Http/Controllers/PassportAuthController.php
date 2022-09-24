<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    //

        /**
        *Registration Module 
        *
        *
        **/

        public function register()
        {
            $this->validate($request,[

                'name'=>'required|min:4',
                'email'=>'required|email',
                'password'=>'required|min:8'

            ]);


                    $user = User::Create([

                        'name'=> $request->name,
                        'email'=> $request->email,
                        'password'=> bcrypt($request->password)
                    ]);

                    $token = $user->CreateToken('LaravelAuthApp')->accessToken;

                    return response()->json(['token'=> $token], 200);
        }

        public function login()
        {
            $data = [

                'email'=>$request->email,
                'password'=>$request->password
            ];


                if (auth()->attempt($data)) {
                    
                    $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

                    return response()->json(['token'=>$token],200);
                }
                else
                {
                    return response()->json('error'=>'Unauthorised',401);
                }
        }
}
