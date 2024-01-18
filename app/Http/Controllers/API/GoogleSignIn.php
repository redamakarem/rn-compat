<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleSignIn extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            // Find user by email
            $existingUser = User::where('email', $user->getEmail())->first();

            if ($existingUser) {
                // User already exists, issue a token
                $token = $existingUser->createToken('compat-token')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $existingUser]);
            } else {
                // User doesn't exist, create a new user
                $newUser = new User;
                $newUser->name = $user->getName();
                $newUser->email = $user->getEmail();
                $newUser->google_id = $user->getId();
                $newUser->email_verified_at = now();
                $newUser->password = Hash::make(Str::random(24)); // Create a random password
                // You can add more fields here if needed
                $newUser->save();

                // Issue a token for the new user
                $token = $newUser->createToken('compat-token')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $user]);
            }
        } catch (Exception $e) {
            // Handle the exception, e.g., log the error or show an error message
            return response()->json(['error' => 'Error occurred while signing in with Google.']);
        }
    }

    public function GoogleLoginWithToken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        try {
            $user = Socialite::driver('google')->stateless()->userFromToken($request->token);

            // Find user by email
            $existingUser = User::where('email', $user->getEmail())->first();

            if ($existingUser) {
                // User already exists, issue a token
                $token = $existingUser->createToken('compat-token')->plainTextToken;
            } else {
                // User doesn't exist, create a new user
                $newUser = new User;
                $newUser->name = $user->getName();
                $newUser->email = $user->getEmail();
                $newUser->google_id = $user->getId();
                $newUser->email_verified_at = now();
                $newUser->password = Hash::make(Str::random(24)); // Create a random password
                // You can add more fields here if needed
                $newUser->save();

                // Issue a token for the new user
                $token = $newUser->createToken('compat-token')->plainTextToken;
            }

            // Return the token to the client
            return response()->json(['token' => $token]);
        } catch (Exception $e) {
            // Handle the exception, e.g., log the error or show an error message
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
