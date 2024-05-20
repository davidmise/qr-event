<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\GuestAttendance;
use Illuminate\Http\Response;

class GuestAttendanceController extends Controller
{
    public function index()
    {
        $attendances = GuestAttendance::with('guest')->get();
        return response()->json($attendances);
    }

    public function store(Request $request)
    {
        $request->validate([
            'created_on' => 'nullable|date',
            'data_expires' => 'nullable|date|after:created_on',
            'status' => 'required|in:Attended,Registered',
            'guest_id' =>'required|exists:guests,id',
        ]);

        $attendance = new GuestAttendance;
        $attendance->guest_id = $request->input('guest_id');
        $attendance->created_on = $request->input('created_on');
        $attendance->data_expires = $request->input('data_expires');
        $attendance->status = $request->input('status');

        $attendance->save();

        return response()->json([
            'status' => true,
            'message' => 'Attendance record created successfully',
            'data' => $attendance,
        ], 201);
    }

    public function show($id)
    {
        $attendance = GuestAttendance::with('guest')->find($id);

        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'Guest attendance record not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Guest attendance record retrieved successfully',
            'data' => $attendance,
        ], 200);
    }
}
