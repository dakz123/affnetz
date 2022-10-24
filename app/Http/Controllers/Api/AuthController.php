<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\User_Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            
            'password' => 'required|string|min:7|confirmed',
        ]);
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => null,
            'password' => bcrypt($data['password'])

        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;
        $role= $user->role;
        return response([
            'user' => $user,
            'token' => $token,
            'role' => $role
        ]);
    }
    public function login(Request $request)
    {
        $data = $request->validate([

            'username' => 'required|string|max:255',
            'password' => 'required|string|min:7',
        ]);
        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => 'Invalid credentials'
            ]);
        }


        $token = $user->createToken('myapptoken')->plainTextToken;
        $role= $user->role;

        return response([
            'user' => $user,
            'token' => $token,
            'role' => $role
        ]);
    }
    public function index()
    {
        return UserResource::collection(User::all());
    }
    public function report(){
        $user=User::all();
        $reports=$user->profiles()->get();
       
        dd($reports);
    }
    
}
