<?php

namespace App\Http\Controllers\API;

use App\Models\AppUser;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends BaseController
{
    /**
     * Signup a new app user.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(SignupRequest $request)
    {
        $responce = User::create($request->all());
        $user = User::find($responce->id);
        return $this->sendResponse(new UserResource($user), 'User registered successfully.');
    }

    /**
     * Signin a app user.
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(SigninRequest $request)
    {
        // Attempt login with email & password
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return sendError('Invalid credentials provided.');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is active
        if (!$user->active()) {
            return sendError('Your account is disabled. Contact your admin.');
        }

        // Generate API token
        $user->token = $user->createToken('user-token')->plainTextToken;

        // Return successful response
        return sendResponse(new UserResource($user), 'User logged in successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
