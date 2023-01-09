<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller as Controller;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->all('email', 'password');

        //if auth failed
        $token = auth()->guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }

    // public function DecryptPasswordUser($id)
    // {
    //     $user = Users::where("id", $id)->first();
    //     $password = Crypt::decryptString($user->password);
    //     return $password;
    // }

    // /**
    //  * return error response
    //  * @return \Illuminate\Http\Response;
    //  */
    // public function signout()
    // {
    //     auth()->user()->tokens()->delete();
    //     $message["message"] = "User has logout";
    //     return response()->json($message, 200);
    // }
}
