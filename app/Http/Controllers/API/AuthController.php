<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
            'country_id' => ['required', 'numeric'],
            'mob' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'device_id' => ['required', 'string'],
        ]);
        $user = User::create($request->only(['name', 'email', 'password']));
        $user->profile()->create([
            'country_id' => $request->country_id,
            'mobile' => $request->mob,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'device_id' => $request->device_id
        ]);
        $user->profile->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }


    public function loginUser()
    {
        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logoutUser()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'User logged out successfully'
        ], 200);
    }
}
