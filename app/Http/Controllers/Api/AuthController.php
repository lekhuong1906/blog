<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function createUser(UserRequest $request){

        try {

            # Create New User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            # Create Cart
            Cart::create([
                'user_id'=>$user->id,
                'total_price'=>0,
                'status'=>1
            ]);


            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
    public function loginUser(Request $request){
        $validateUser = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if ($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);}

        $user = User::where('email',$request->email)->first();
        if ($user && Hash::check($request->password,$user->password)){

            $token = $user->createToken($user->name)->plainTextToken;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $token
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Email & Password does not match with our record.',
        ], 401);
    }

}
