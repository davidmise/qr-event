<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInfo;
use Illuminate\Support\Facades\Validator;

class EventInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = EventInfo::with([
        'Location',
        'Organizer',
        'SocialLink',
        'Ticket',
        'media'
        ])->get();
        return response()->json($events);
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
            'event_name' => 'required|string',
            'event_subtitle' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date', // Ensure end date is after start date
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time', // Ensure end time is after start time
            'location_id' => 'required|exists:locations,id',
            'organizer_id' => 'required|exists:users,id',
            'ticket_id' => 'required|exists:tickets,id',
           'media_id' => 'required|exists:medias,id',
        ];
        $messages = [
            // name
            'event_name.required' => 'Name is required',
            'event_name.string' => 'Name must be a string',
            'event_name.max' => 'Name must be less than 255 characters',
            // subtitle
            'event_subtitle.string' => 'Subtitle must be a string',
            'event_subtitle.max' => 'Subtitle must be less than 255 characters',
            'event_subtitle.required' => 'Subtitle is Required',
            // start date
            'start_date.required' => 'Start Date is required',
            'start_date.date' => 'Start Date must be a date',
            // end date
            'end_date.date' => 'End Date must be a date',
            'end_date.after' => 'End Date must be after Start Date',
            // start time
            'start_time.required' => 'Start Time is required',
            'start_time.date_format' => 'Start Time must be a date',
            // end time
            'end_time.required' => 'End Time is Required',
            'end_time.after' => 'End Time must be after Start Time',
            // location_id
            'location_id.required' => 'Location is required',
            'location_id.exists' => 'Location does not exist',
            // organizer_id
            'organizer_id.required' => 'Organizer is required',
            'organizer_id.exists' => 'Organizer does not exist',
            // ticket_id
            'ticket_id.required' => 'Ticket is required',
            'ticket_id.exists' => 'Ticket does not exist',
            // media_id
           'media_id.required' => 'Media is required',
           'media_id.exists' => 'Media does not exist',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $event_info = new EventInfo([
            'event_name' => $request->input('event_name'),
            'event_subtitle' => $request->input('event_subtitle'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'location_id' => $request->input('location_id'),
            'organizer_id' => $request->input('organizer_id'),
            'ticket_id' => $request->input('ticket_id'),
            'media_id' => $request->input('media_id'),
        ]);
        $event_info->save();

        return response()->json([
            'status' => true,
            'message' => 'Event Info created successfully',
            'data' => $event_info
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
}
