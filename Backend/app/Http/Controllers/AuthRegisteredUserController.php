<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Laravel\Passport\HasApiTokens;

class AuthRegisteredUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //display all users
        $users = User::get();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //create a new user
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];

        $messages = [
            // name
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 255 characters',
            // username
            'username.required' => 'UserName is required',
            'username.string' => 'UserName must be a string',
            'username.max' => 'UserName must be less than 255 characters',
            'username.unique' => 'username is already taken',

            // email
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.unique' => 'Email is already taken',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), //  hash the password
        ]);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        return response()->json(
            [
                'message' => " from data captured  by api succesfully",
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user,  string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    'message' => "User not found",
                ]
            );
        } else {
            return response()->json(
                [
                    "status" => true,
                    'message' => "User found",
                    'data' => $user
                ]

            );
        }
    }
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ];

        $messages = [
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $credentials = $request->validate([
            'email' => 'required|email|max:225|string',
            'password' => 'required|string|min:8',
        ]);

        if (auth()->attempt($credentials)) {
            /** @var  **/
            $user = auth()->user();
            $token = $user->createToken('authToken')->plainTextToken; // Generate API token
            // $token = $user->createToken('authToken')->plainTextToken; // Generate API token

            // $tokenResult = $user->createToken('Personal Access Token');
            // $token = $tokenResult->token;
            // if ($request->remember_me)
            //     $token->expires_at = Carbon::now()->addWeeks(1);
            // $token->save();

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials, user login Failed.',
            ], 401);
        }
    }

    public function logout()
    {
        /** @var \App\Models\User $user **/
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
