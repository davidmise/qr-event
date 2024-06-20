<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $guests = Guest::paginate(10);
        return $guests; // Assuming you have an 'index.blade.php' view for guests

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required|string',
            'email' => 'email|nullable', // Unique email validation
            'phone_number' => 'required|numeric|integer',
            'guest_attendance_id'=>'nullable|existing',
            'qr_code' => 'nullable|string',
            'event_info_id' => 'required'
        ];
        $messages = [
            // name
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 255 characters',
            // email

            'email.email' => 'Invalid email address',
            'email.unique' => 'Email is already taken',
            // phone_number
            'phone_number.required' => 'Email is required',
            'phone_number.numeric' => 'Phone must be a string',
            'phone_number.max' => 'Phone must be less than 255 characters',
            // guest_attendance_id
            // 'guest_attendance_id.required' => 'guest_attendance_id is required',
            'guest_attendance_id.exists' => 'guest_attendance_id does not exist',
            // event_info_id
            'event_info_id.required' => 'event_info_id is required',
            // 'event_info_id.exists' => 'event_info_id does not exist',
            // qr_code
            // 'qr_code.string' => 'qr_code must be a string',
            // 'qr_code.max' => 'qr_code must be less than 255 characters',
            'qr_code.unique' => 'qr_code is already taken',
            // qr_code


        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $guest = new Guest([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'event_info_id' => $request->input('event_info_id')
        ]);
        $guest->save();

        return response()->json([
            'status' => true,
            'message' => 'Guest created successfully',
            'data' => $guest
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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

        $guest = Guest::query()->where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('email', 'LIKE', "%$searchTerm%")
            ->paginate(10);

            // if ($guest->isEmpty()) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'guest not found'
            //     ], 404); // Not Found
            // }

        return response()->json([
            'status'=>true,
            'message' => 'guest searched successfully',
            'guest' => $guest
        ], 200);

}

public function markAttendance(Request $request)
    {
        $guestId = $request->input('guestId');
        $status = $request->input('status');

        $guest = Guest::find($guestId);
        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }

        $guest->status = $status;
        $guest->save();

        return response()->json(['message' => 'Status updated successfully'], 200);
    }

}
