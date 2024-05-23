<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::paginate(5);
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            // 'phone_number' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,host,doorman'
        ];

        $validator = Validator::make($request->all(), $rules);

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
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "status" => false,
                'message' => "User not found",
            ],404);
        } else {
            return response()->json([
                "status" => true,
                'message' => "User found",
                'user' => $user
            ],200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation rules
        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $id,
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'role' => 'sometimes|required|in:admin,host,doorman'
        ];

        // Validate the input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "status" => false,
                'message' => "User not found",
            ], 404);
        }

        // Update user details
        if ($request->has('name')) $user->name = $request->input('name');
        if ($request->has('username')) $user->username = $request->input('username');
        if ($request->has('email')) $user->email = $request->input('email');
        if ($request->has('password')) $user->password = bcrypt($request->input('password'));
        if ($request->has('role')) $user->role = $request->input('role');

        // Save the updated user information
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
