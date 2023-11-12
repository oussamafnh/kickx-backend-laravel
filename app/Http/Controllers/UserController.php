<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getStatusByUsername($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $isLoggedIn = Auth::check() && Auth::user()->id === $user->id;

        return response()->json([
            'username' => $user->username,
            'status' => $isLoggedIn ? 'logged in' : 'not logged in',
        ]);
    }

    public function getUserStatistics()
    {
        $totalUsers = User::count();
        $loggedInUsers = Auth::check() ? 1 : 0;

        return response()->json([
            'total_users' => $totalUsers,
            'logged_in_users' => $loggedInUsers,
        ]);
    }

    public function getUserProfile()
    {
        $user = auth()->user();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $profileData = [
            'username' => $user->username,
            'email' => $user->email,
            'profile_picture' => $user->profile_picture,
            // Add more fields as needed
        ];
    
        return response()->json($profileData);
    }

    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'profile_picture' => 'url',
            'password' => 'required|min:6',
            // Add more validation rules as needed
        ]);

        $user->update([
            'email' => $request->input('email', $user->email),
            'password' => Hash::make($request->password),
            'profile_picture' => $request->input('profile_picture', $user->profile_picture),
            // Update more fields as needed
        ]);

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function getAllUsers()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
    public function deleteselfUser()
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully']);
    }
    
}
