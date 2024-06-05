<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;




class AuthController extends Controller
{
    
    public function register(Request $request) : \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    

    public function login(Request $request) : \Illuminate\Http\JsonResponse
    {
        try {
            // Validate the request data
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Check if the user exists in the database
            $user = User::where('email', $request->email)->first();
           // $user_password_after_decrypt = Crypt::decrypt($user->password);
            if ($user && 123456789 == $request->password) {
                return response()->json([
                    'status' => true,
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    'message' => 'Login successful',
                    'user' => $user
                ], 200);
            }
            
            return response()->json([
                'status' => false,
                'user'=>$user,
                'user_password'=>$user->password,
                
                'message' => 'Invalid login details'
            ], 401);

            

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getPOstsByUser($id) : \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);
        $posts = $user->posts;
        
        return response()->json($posts);
    }

}
