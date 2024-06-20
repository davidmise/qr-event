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
        $users = User::paginate(10);
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
            'role' => 'nullable|in:admin,host,doorman'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $role = $request->input('role', 'host');

        $user = new User([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $role,
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
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Delete the book record
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search_term');

        // if(!$searchTerm) {
        //     return response()->json([
        //         'status'=>false,
        //         'message' => 'user not found'
        //     ],400); // bad request
        // }

        $users = User::query()->where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('username', 'LIKE', "%$searchTerm%")
            ->orWhere('email', 'LIKE', "%$searchTerm%")
            ->orWhere('role', 'LIKE', "%$searchTerm%")
            ->paginate(10);

            // if ($users->isEmpty()) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'User not found'
            //     ], 404); // Not Found
            // }

        return response()->json([
            'status'=>true,
            'message' => 'Users searched successfully',
            'users' => $users
        ], 200);
    }


//     public function search(Request $request)
// {
//     $rules = [
//         'name' => 'nullable|string|max:255',
//         'username' => 'nullable|string|max:255',
//         'email' => 'nullable|string|email|max:255',
//         'role' => 'nullable|in:admin,host,doorman',
//         'page' => 'nullable|integer|min:1',
//         'per_page' => 'nullable|integer|min:1|max:100'
//     ];

//     $validator = Validator::make($request->all(), $rules);

//     if ($validator->fails()) {
//         return response()->json([
//             'status' => false,
//             'errors' => $validator->errors()
//         ], 422);
//     }

//     $query = User::query();

//     if ($request->has('name')) {
//         $query->where('name', 'like', '%' . $request->input('name') . '%');
//     }

//     if ($request->has('username')) {
//         $query->where('username', 'like', '%' . $request->input('username') . '%');
//     }

//     if ($request->has('email')) {
//         $query->where('email', 'like', '%' . $request->input('email') . '%');
//     }

//     if ($request->has('role')) {
//         $query->where('role', $request->input('role'));
//     }

//     // Pagination
//     $perPage = $request->input('per_page', 10);
//     $page = $request->input('page', 1);

//     $users = $query->paginate($perPage, ['*'], 'page', $page);

//     return response()->json([
//         'status' => true,
//         'users' => $users->items(),
//         'current_page' => $users->currentPage(),
//         'last_page' => $users->lastPage(),
//         'per_page' => $users->perPage(),
//         'total' => $users->total()
//     ], 200);
// }


}
