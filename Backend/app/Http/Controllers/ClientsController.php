<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clients = Client::with('event')->paginate(10);

        return $clients;
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'event_type' => 'required|in:Wedding,Exhibition,Coorporate,Seminars,Festivals,Conference,Others',
            'cost' => 'required|integer|min:0.01', // Minimum price of 0.01
            'event_capacity' => 'required|integer|min:1', // Minimum capacity of 1
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $client = new Client([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'event_type' => $request->input('event_type'),
            'cost' => $request->input('cost'),
            'event_capacity' => $request->input('event_capacity'),
         ]);

         $client->save();

         return response()->json([
            'status' => true,
            'message' => 'Client created successfully',
            'client' => $client
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
        //         'message' => 'client not found'
        //     ],400); // bad request
        // }

        $client = Client::query()->where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('email', 'LIKE', "%$searchTerm%")
            ->paginate(10);

            // if ($client->isEmpty()) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'client not found'
            //     ], 404); // Not Found
            // }

        return response()->json([
            'status'=>true,
            'message' => 'client searched successfully',
            'client' => $client
        ], 200);

    }

}
