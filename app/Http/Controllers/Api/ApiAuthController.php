<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'jabatan' => 'required|string|min:5',
            'nip' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

//muhammad fachrizal shiddiq
//-6.2809811,106.8393438

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'location' => [
                'lat' => '-6.2809811',
                'long' => '106.8393438'
            ],
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Password atau Email Salah'
            ], 404);
        }

        $user = User::where('email', $request->email)->first();
        if ($user === null) {
            return response()->json([
                'message' => 'User not found'
            ], 404); // Status code 404 for "Not Found"
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }

    public function whoIam(Request $request)
    {

        return response()->json([
            'message' => 'Login success',
            'access_token' =>  $request->token,
            'token_type' => 'Bearer',
            'user' => $request->user()
        ]);
    }
}
