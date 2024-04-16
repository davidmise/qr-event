<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $locations = Location::all();
        return response()->json($locations);

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
        $rules =[
            'city' =>'required|string',
            'country' =>'required|string',
            'street' =>'required|string',
            'postal_code' =>'required|string',
            'google_map_url' => 'nullable|string',
        ];

        $messages =[
            // city
            'city.required' => 'city is required',
            'city.string' => 'city must be a string',
            'city.max' => 'city must be less than 255 characters',
            // country
            'country.required' => 'country is required',
            'country.string' => 'country must be a string',
            'country.max' => 'country must be less than 255 characters',
            // street
            'street.required' => 'street is required',
            'street.string' => 'street must be a string',
            'street.max' => 'street must be less than 255 characters',
            // postal_code
            'postal_code.required' => 'postal_code is required',
            'postal_code.string' => 'postal_code must be a string',
            'postal_code.unique' => 'postal_code is already taken',
            // google_map_url'
            // 'google_map_url.required' => 'google_map_url is required',
            'google_map_url.string' => 'google_map_url must be a string',
            // 'google_map_url.unique' => 'google_map_url is already ',
        ];
        $validator = Validator::make($request -> all(), $rules, $messages);

        if($validator -> fails())
        {
            return response() -> json([
               'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $location = new Location([
            'city' => $request -> input('city'),
            'country' => $request -> input('country'),
            'street' => $request -> input('street'),
            'postal_code' => $request -> input('postal_code'),
            'google_map_url' => $request -> input('google_map_url'),
        ]);

        $location->save();

        return response()->json([
               'status' => true,
               'message' => 'Location created successfully',
                'data' => $location
            ],201);
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
