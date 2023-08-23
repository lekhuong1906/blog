<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function createUserAdmin(UserRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->is_admin = true; // Set quyền admin
            $user->save();

            return response()->json(['message' => 'User admin created successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()]);
        }
    }


    public function createUserCustomer(UserRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->is_admin = false; // Set quyền customer
            $user->save();

            return response()->json(['message' => 'User customer created successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('authToken')->plainTextToken;
            if ($user->isAdmin())
                return response()->json([
                    'message' => 'Logged in as admin',
                    'token' => $token,
                    'is_admin' =>true
                ], 200);
            else
                return response()->json([
                    'message' => 'Logged in as customer',
                    'token' => $token,
                    'is_admin'=>false
                ], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
