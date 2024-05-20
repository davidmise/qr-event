<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $organizers = Organizer::all();
        return response()->json($organizers);
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
            'email' => 'required|email', // Unique email validation
            'phone' => 'nullable|string',
            'event_info_id'=>'nullable|string',
        ];
        $messages = [
            // name
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 255 characters',
            // email
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.unique' => 'Email is already taken',
            // phone
            'phone.string' => 'Phone must be a string',
            'phone.max' => 'Phone must be less than 255 characters',
            // event_info_id
            'event_info_id.required' => 'event_info_id is required',
            'event_info_id.unique' => 'event_info_id must be a unique',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $organizer = new Organizer([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'event_info_id' => $request->input('event_info_id'),
        ]);
        $organizer->save();

        return response()->json([
            'status' => true,
            'message' => 'Organizer created successfully',
            'data' => $organizer
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
