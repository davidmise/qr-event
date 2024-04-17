<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialLink; // Replace with your model name if different
use Illuminate\Support\Facades\Validator; // For validation

class SocialLinkController extends Controller
{
    public function index()
{
    $socialLinks = SocialLink::all(); // Retrieve all social links

    return response()->json($socialLinks);
}
    /**
     * Store or update social links.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instagram' => 'nullable|url', // Optional, validate if provided
            'facebook' => 'nullable|url',   // Optional, validate if provided
            'website' => 'nullable|url',    // Optional, validate if provided
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Unprocessable Entity
        }

        $socialLink = SocialLink::first(); // Retrieve existing record (assuming one)

        if (!$socialLink) {
            $socialLink = new SocialLink; // Create new if none exists
        }

        $socialLink->fill($request->all()); // Fill with validated data
        $socialLink->save();

        return response()->json([
            'status' => true,
            'message' => 'Social Link updated successfully',
            'data' => $socialLink
        ], 201); // Created or Updated response
    }
}
