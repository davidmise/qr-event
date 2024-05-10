<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\GuestAttendance;
use Illuminate\Http\Response;

class GuestAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *  @param Guest $guest
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = GuestAttendance::with('guest')->get();
        return response()->json($attendances);
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
     * Create a new guest attendance record (API endpoint).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Guest $guest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Guest $guest)
    {
        $request->validate([
            // 'info' => 'nullable|string',
            'created_on' => 'nullable|date',
            'data_expires' => 'nullable|date|after:created_on',
            'status' => 'required|in:Attended,Registered',
            'guest_id' =>'nullable|exists:guests,id',
        ]);

        $attendance = new GuestAttendance;
        $attendance->guest_id = $guest->id;
        // $attendance->info = $request->input('info');
        $attendance->created_on = $request->input('created_on');
        $attendance->data_expires = $request->input('data_expires');
        $attendance->status = $request->input('status');

        $attendance->save();

        return response()->json([
            'status' => true,
            'message' => 'Attendance record created successfully',
            'data' => $attendance,
        ], 201); // Return the created attendance record with status code 201 (Created)
    }


   /**
 * Display the specified resource.
 * Retrieve and return a specific guest attendance record based on ID (API endpoint).
 *
 * @param string $id
 * @return \Illuminate\Http\Response
 */
public function show(string $id)
{
    $attendance = GuestAttendance::with('guest')->find($id);

    if (!$attendance) {
        return response()->json([
            'status' => false,
            'message' => 'Guest attendance record not found',
        ], 404); // Return status code 404 (Not Found) if record not found
    }

    return response()->json([
        'status' => true,
        'message' => 'Guest attendance record retrieved successfully',
        'data' => $attendance,
    ], 200); // Return the retrieved attendance record with status code 200 (OK)
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
}
