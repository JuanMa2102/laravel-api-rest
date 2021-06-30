<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => ['required','string','max:150'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string']
         ]);

         $request = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $request->createToken($request->email)->plainTextToken;

        return response()->json([
                'res' => true,
                'token' => $token
        ], 200);
    }

    public function login(Request $request){
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
                'res' => true,
                'token' => $token
        ],200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'res' => true,
            'messages' => 'Se ha cerrado secion correctamente'
        ],200);
    }
}
