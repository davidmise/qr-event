<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Validator; // For validation

class MediaController extends Controller
{
    public function index()
    {
        $medias = Media::all();
        return response()->json($medias);
    }
    /**
     * Store media information for an event.
     *

     */
    public function store(Request $request)
    {
        $rules = [
            'poster' => 'required|url', // Ensure valid URL for poster
            'banner' => 'nullable|url',  // Optional banner URL
            'logo' => 'nullable|url',    // Optional logo URL
            'event_info_id' => 'nullable',
        ];

        $messages = [
            'poster.required' => 'poster is required',
            'poster.url' => 'poster must be a valid URL',
            'banner.url' => 'banner must be a valid URL',
            'logo.url' => 'logo must be a valid URL',
            // event_info_id
            // 'event_info_id.required' => 'event_info_id is required',
            'event_info_id.unique' => 'event_info_id must be a unique',
            // 'event_info_id.max' => 'event_info_id must be less than 255 characters',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $media = new Media([
            'poster' => $request->input('poster'),
            'banner' => $request->input('banner'),
            'logo' => $request->input('logo'),
            'event_info_id' => $request->input('event_info_id'),
        ]);
        $media->save();
        return response()->json([
            'status' => true,
            'message' => 'Media created successfully',
            'data' => $media,
        ], 201);
    }
}
    // Add additional methods like update and delete if needed
