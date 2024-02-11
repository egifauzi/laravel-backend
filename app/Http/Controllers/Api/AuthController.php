<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|max:30',
                'email' => 'required|unique:users|max:30',
                'password' => 'required',
                'phone' => 'required',
                'roles' => 'required',
            ]
            );

            // $validated['password'] = Hash::make($validated['password']);

            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(
                [
                    'access_token' => $token,
                    // 'token_type' => 'Bearer',
                    'user' => $user
                ], 201
                );

    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successfully'
        ], 200);
    }
    public function login(Request $request){
        //validate the request
        $validated = $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
            );
            $user = User::where('email', $validated['email'])->first();

           if (!$user){
            return response()->json([
                'message' => 'User Not Found'
            ], 401);
        }
        if ($user){
            if (!Hash::check($validated['password'], $user->password)){
                return response()->json([
                    'message' => 'Wrong Password'
                ], 401);
            }
        }

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                // 'token_type' => 'Bearer',
                'user' => $user
            ], 200);
    }
}

