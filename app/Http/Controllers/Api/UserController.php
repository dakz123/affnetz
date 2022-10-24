<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Models\User_Profile;
use Illuminate\Http\Request;

use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id=$request->id;
        return UsersResource::collection(User::find($id)->profiles()->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $id = $user->id;
       

        $count =  User::find($id)->profiles()->count();
        if ($count === 3) {
            return response()->json([
                'message' => 'Profile already created'
            ]);
        } else {
            $data = $request->validate([
                'profile_name' => 'required|string',
                'user_email' => 'required|string|email',
                'user_phone' => 'max:10',
                'user_address' => 'max:100',
            ]);

            $user = new User_Profile();
            $user->profile_name = $data['profile_name'];
            $user->user_email = $data['user_email'];
            $user->user_phone = $data['user_phone'];
            $user->user_address = $data['user_address'];
            $user->user_id = $id;
            $user->save();
            return response($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User_Profile  $user_Profile
     * @return \Illuminate\Http\Response
     */
    public function show(User_Profile $user_Profile)
    {
        return new UsersResource($user_Profile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User_Profile  $user_Profile
     * @return \Illuminate\Http\Response
     */
    public function edit(User_Profile $user_Profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User_Profile  $user_Profile
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User_Profile $user_Profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User_Profile  $user_Profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_Profile $user_Profile)
    {
        //
    }
}
