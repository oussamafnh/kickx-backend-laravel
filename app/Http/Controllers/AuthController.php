<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->input('is_admin', false)
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $hash = Str::random(60); 
            $token = hash('sha256', $hash);
            $user->api_token = $token; 
            $user->update();

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
    
        // Revoke or invalidate the token on the client side
        $user->api_token = null;
        $user->save();
    
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}













// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Validator;
// use App\Http\Controllers\Controller;
// use Laravel\Sanctum\Sanctum;
// use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Hash;

// class AuthController extends Controller
// {



//     public function register(Request $request)
//     {
//         $request->validate([
//             'username' => 'required|string|max:255',
//             'email' => 'required|string|email|unique:users|max:255',
//             'password' => 'required|string',
//         ]);

//         $user = User::create([
//             'username' => $request->username,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'is_admin' => $request->input('is_admin', false)
//         ]);

//         return response()->json([
//             'message' => 'User registered successfully',
//             'user' => $user,
//         ], 201);
//     }



//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|string|email',
//             'password' => 'required|string',
//         ]);
    
//         $credentials = $request->only('email', 'password');
    
//         if (Auth::attempt($credentials)) {
//             $user = Auth::user();
//             $token = $user->createToken('authToken')->plainTextToken;
    
//             return response()->json([
//                 'message' => 'Login successful',
//                 'user' => $user,
//                 'access_token' => $token,
//             ]);
//         }
    
//         return response()->json(['message' => 'Invalid credentials'], 401);
//     }


//     public function logout()
//     {
//         // $request->user()->tokens()->delete();
    
//         return response()->json([
//             'message' => 'ok ok ok',
//         ]);
//     }











    // public function register(Request $request)
    // {
    //     $data = $request->validate([
    //         'username' => 'required|string',
    //         'email' => 'required|string|unique:users,email',
    //         'password' => 'required|string'
    //     ]);

    //     $user = User::create([
    //         'username' => $data['username'],
    //         'email' => $data['email'],
    //         'password' => bcrypt($data['password']),
    //         'is_admin' => $request->input('is_admin', false),

    //     ]);

    //     $token = $user->createToken('apiToken')->plainTextToken;

    //     $res = [
    //         'user' => $user,
    //         'token' => $token
    //     ];
    //     return response($res, 201);
    // }



    // public function login(Request $request)
    // {
    //     $data = $request->validate([
    //         'email' => 'required|string',
    //         'password' => 'required|string'
    //     ]);

    //     $user = User::where('email', $data['email'])->first();

    //     if (!$user || !Hash::check($data['password'], $user->password)) {
    //         return response([
    //             'msg' => 'incorrect username or password'
    //         ], 401);
    //     }

    //     $token = $user->createToken('apiToken')->plainTextToken;

    //     $res = [
    //         'user' => $user,
    //         'token' => $token
    //     ];

    //     return response($res, 201);
    // }


    // public function logout(Request $request)
    // {

    //     auth()->user()->tokens()->delete();
    //     return [
    //         'message' => 'user logged out'
    //     ];
    // }















    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6',
    //         'is_admin' => 'boolean' // If is_admin is included in the request
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     $user = User::create([
    //         'username' => $request->username,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'is_admin' => $request->input('is_admin', false),
    //     ]);

    //     return response()->json(['message' => 'User registered successfully'], 201);
    // }


    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $token = $request->user()->createToken('apitoken')->plainTextToken;
    //         return response()->json(['token' => $token, 'message' => ' user has login successfully'], 200);
    //     }

    //     return response()->json(['error' => 'Invalid credentials'], 401);
    // }

    // public function logout(Request $request)
    // {
    //     $request->user()->token()->revoke();
    //     return response()->json([
    //         'message' => 'Successfully logged out'
    //     ]);
    // }
// }
