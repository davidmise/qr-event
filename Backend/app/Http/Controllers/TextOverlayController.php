<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextOverlay;

class TextOverlayController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'identifier' => 'required|string',
            'overlays' => 'required|array',
            'overlays.*.x' => 'required|integer',
            'overlays.*.y' => 'required|integer',
            'overlays.*.font_size' => 'required|integer',
            'overlays.*.font_family' => 'required|string',
            'overlays.*.font_color' => 'required|string',
            'event_info_id' => 'required|integer|exists:event_infos,id',
        ]);

        foreach ($validatedData['overlays'] as $overlay) {
            TextOverlay::create([
                'identifier' => $validatedData['identifier'],
                'x' => $overlay['x'],
                'y' => $overlay['y'],
                'font_size' => $overlay['font_size'],
                'font_family' => $overlay['font_family'],
                'font_color' => $overlay['font_color'],
                'event_info_id' => $validatedData['event_info_id']
            ]);
        }

        return response()->json(['message' => 'Overlays saved successfully']);
    }


    public function show($identifier)
    {
        $overlays = TextOverlay::where('identifier', $identifier)->get();
        return response()->json($overlays);
    }
}
