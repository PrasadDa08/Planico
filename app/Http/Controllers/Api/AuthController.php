<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User Registered Successfully'
        ], 201);
    }

    public function Login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User Logged In Successfully',
            'token' => $token
        ], 200);
    }

    public function Logout()
    {

        $token = auth('sanctum')->user()->currentAccessToken();
        $token->delete();
        return response()->json([
            'message' => 'User Loggedout successfully',
        ], 200);
    }
}
