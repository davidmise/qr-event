<?php

namespace App\Http\Controllers;

use \App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tickets = Ticket::all();
        return response()->json($tickets);
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
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'price' => 'required|numeric|min:0.01', // Minimum price of 0.01
            'event_capacity' => 'required|integer|min:1', // Minimum capacity of 1
        ]);

        $ticket = Ticket::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Ticket created successfully',
            'data' => $ticket
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
        $ticket = Ticket::find($id);

        // Check if ticket exists (optional)
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        return response()->json([
            'message'=> 'Ticket updated successfully',
            'data' => $ticket
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::find($id);

        // Check if ticket exists (optional)
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        // Validation rules (adjust as needed)
        $this->validate($request, [
            'price' => 'nullable|numeric|min:0.01',
            'event_capacity' => 'nullable|integer|min:1',
        ]);

        // Update the ticket with request data
        $ticket->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Ticket updated successfully',
            'data' => $ticket
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
