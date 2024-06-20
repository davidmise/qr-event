<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInfo;
use Illuminate\Support\Facades\Validator;

use App\Models\Guest;
use App\Models\Organizer;
use App\Models\Ticket;
use App\Models\Location;
// use App\Models\Media;
use App\Models\SocialLink;
use App\Models\GuestAttendance;


class EventInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Set default pagination values
    // $perPage = $request->input('per_page', 10);
    // $page = $request->input('page', 1);

    // Query events with relationships
    $events = EventInfo::with('Location', 'Organizer', 'SocialLink', 'ticket','guests', 'attendance.guest')
        ->paginate(10);

    return $events;
   
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
            'end_date' => 'nullable|date', // Ensure end date is after start date
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time', // Ensure end time is after start time
            // 'location_id' => 'exists:locations,id',
            // 'organizer_id' => 'exists:users,id',
            // 'ticket_id' => 'exists:tickets,id',
            // 'media_id' => 'exists:medias,id',
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
            // // location_id
            // // 'location_id.required' => 'Location is required',
            // 'location_id.exists' => 'Location does not exist',
            // // organizer_id
            // // 'organizer_id.required' => 'Organizer is required',
            // 'organizer_id.exists' => 'Organizer does not exist',
            // // ticket_id
            // // 'ticket_id.required' => 'Ticket is required',
            // 'ticket_id.exists' => 'Ticket does not exist',
            // // media_id
            // //    'media_id.required' => 'Media is required',
            // 'media_id.exists' => 'Media does not exist',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        // Create EventInfo record
        $event_info = EventInfo::create([
            'event_name' => $request->input('event_name'),
            'event_subtitle' => $request->input('event_subtitle'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
        ]);

        // Create related records(organizer)
        $organizer = Organizer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'event_info_id' => $event_info->id,
        ]);
        // Create related records(ticket)
        $ticket = Ticket::create([
            'price' => $request->input('price'),
            'event_capacity' => $request->input('event_capacity'),
            'event_info_id' => $event_info->id,
        ]);
        // Create related records(location)
        $location = Location::create([
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'street' => $request->input('street'),
            'postal_code' => $request->input('postal_code'),
            'google_map_url' => $request->input('google_map_url'),
            'event_info_id' => $event_info->id,
        ]);

        // Create related records(social_links)
        $socialLink = SocialLink::create([
            'instagram' => $request->input('instagram'),
            'facebook' => $request->input('facebook'),
            'website' => $request->input('twitter'),
            'event_info_id' => $event_info->id,
        ]);


        // //  Associate EventInfo with related records
        // $event_info->location()->associate($location);
        // $event_info->organizer()->associate($organizer);
        // $event_info->ticket()->associate($ticket);
        // $event_info->media()->associate($media);
        // $event_info->socialLink()->associate($socialLink);

        // Save EventInfo
        $event_info->save();



        // Prepare the data to include foreign keys and their associated data
        $foreignKeysData = [
            'organizer' => $organizer,
            'ticket' => $ticket,
            'location' => $location,
            // 'media' => $media,
            'socialLink' => $socialLink,
        ];
        return response()->json([
            'status' => true,
            'message' => 'Event Info created successfully',
            'event' => [
                'event_info' => $event_info,
                'foreign_keys_data' => $foreignKeysData,
            ]

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:event_infos,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $event_info = EventInfo::with([
            'Location',
            'Organizer',
            'SocialLink',
            'Ticket',
            // 'media',
            'guests',
            'attendance.guests'
        ])->find($id);

        if (!$event_info) {
            return response()->json([
                'status' => false,
                'message' => 'Event Info not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            // 'event_info' => "event info found",
            'event' => $event_info
        ], 200);
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

        // if(!$searchTerm){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'event not found'
        //     ], 400); //bad request

        // }

        $events = EventInfo::with(['location', 'organizer'])
            ->where('event_name', 'LIKE', "%$searchTerm%")
            ->orWhere('event_subtitle', 'LIKE', "%$searchTerm%")
            ->orWhereHas('location', function ($query) use ($searchTerm) {
                $query->where('city', 'LIKE', "%$searchTerm%")
                    ->orWhere('country', 'LIKE', "%$searchTerm%")
                    ->orWhere('street', 'LIKE', "%$searchTerm%")
                    ->orWhere('postal_code', 'LIKE', "%$searchTerm%");
            })
            ->orWhereHas('organizer', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%$searchTerm%")
                    ->orWhere('email', 'LIKE', "%$searchTerm%")
                    ->orWhere('phone', 'LIKE', "%$searchTerm%");
            })
            ->paginate(10);

            // if($events->isEmpty()) {
            //     return response()-> json([
            //         'status' => false,
            //         'message' => 'Event not found'
            //     ],404); //Not Found
            // }

        return response()->json([
            'message' => 'Events searched successfully',
            'event' => $events
        ], 200);
    }

      /**
     * Display guests of a specific event with pagination.
     *
     * @param string $eventId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function guests($eventId, Request $request)
    {
        // Validate event ID
        $validator = Validator::make(['event_id' => $eventId], [
            'event_id' => 'required|integer|exists:event_infos,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Retrieve the event and its guests with pagination
        $event = EventInfo::with('guests')->findOrFail($eventId);
        
        // Paginate guests related to this event
        $perPage = $request->input('per_page', 10); // Items per page, default to 10
        $guests = $event->guests()->paginate($perPage);

        return response()->json([
            'status' => true,
            'event_name' => $event->event_name, // Optionally return event details
            'guests' => $guests
        ], 200);
    }

}
