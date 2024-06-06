<?php

namespace App\Http\Controllers;

use App\Models\GuestList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guests = GuestList::get();
        return response()->json($guests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string', // Considering phone number as a string
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $guest = GuestList::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
        ]);

        return response()->json(['message' => 'Guest created successfully', 'guest' => $guest], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $guest = GuestList::find($id);
        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }
        return response()->json($guest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $guest = GuestList::find($id);
        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string', // Considering phone number as a string
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $guest->fill($request->all());
        $guest->save();

        return response()->json(['message' => 'Guest updated successfully', 'guest' => $guest]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guest = GuestList::find($id);
        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }
        $guest->delete();
        return response()->json(['message' => 'Guest deleted successfully']);
    }
}

